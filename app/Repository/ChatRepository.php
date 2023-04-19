<?php
namespace App\Repository;
use App\Http\Services\CommonService;
use App\Model\Bank;
use App\Model\Chat;
use App\Services\Logger;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ChatRepository
{
    public $logger;
    public function __construct()
    {
        $this->logger = new Logger();
    }

    // user message list
    public function messageList($sender_id, $order_id)
    {
        try {
            $response['chat_list'] = [];
            $messages = Chat::where('order_id', $order_id)->get();
            $messageList = [];
            if (isset($messages[0])) {
                foreach ($messages as $message) {
                    $messageList[] = $this->fetchMessage($message);
                }
                $response = [
                    'success' => true,
                    'chat_list' => $messageList
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => __('No message available'),
                    'chat_list' => []
                ];
            }
        } catch (\Exception $e) {
            $this->logger->log('messageList', $e->getMessage());
            $response = [
                'success' => false,
                'chat_list' => [],
                'message' => __('Something Went wrong !')
            ];
            return $response;
        }
        return $response;
    }

    // message save process
    public function sendOrderMessage($request)
    {
        try {
            if (empty($request->message) && empty($request->file)) {
                $response = [
                    'success' => false,
                    'message' => __('You can not send empty message')
                ];
                return $response;
            }

            $checkFile = $this->checkFileAtSendMsg($request);
            if ($checkFile['success'] == false) {
                return $checkFile;
            }

            $data = [
                'sender_id' => Auth::user()->id,
                'message' => $request->message,
                'order_id' => $request->order_id,
                'receiver_id' => decrypt($request->receiver_id),
            ];

            if (!empty($request->file)) {
                $attachment = $checkFile['data']['attachment'];
                $attachment_title = $checkFile['data']['attachment_title'];
                $data['file'] =($attachment) ? json_encode((object)[
                    'new_name' => $attachment,
                    'old_name' => htmlentities(trim($attachment_title), ENT_QUOTES, 'UTF-8'),
                ]) : null;
            }

            $saveData = Chat::create($data);
            if ($saveData) {
                $msgData = $this->fetchMessage($saveData);
                $heading = Auth::user()->username.' messaged you.';
                app(CommonService::class)->sendNotificationToUser($saveData->receiver_id,$heading,$saveData->message);
                $response = [
                    'success' => true,
                    'message' => __('New message send successfully'),
                    'data' => $msgData
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Failed to send')
                ];
            }

        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
//                'message' => __('Something Went wrong !')
            ];
            return $response;
        }

        return $response;
    }

// fetch sms data
    public function fetchMessage($msg)
    {
        $attachment = null;
        $attachment_path = null;
        $attachment_type = null;
        $attachment_title = null;
        $attachment_with_download_url = null;
        if(isset($msg->file)){
            $attachmentOBJ = json_decode($msg->file);
            $attachment = $attachmentOBJ->new_name;
            $attachment_title = htmlentities(trim($attachmentOBJ->old_name), ENT_QUOTES, 'UTF-8');

            $ext = pathinfo($attachment, PATHINFO_EXTENSION);
            $attachment_type = in_array($ext,$this->getAllowedImages()) ? 'image' : 'file';
            $attachment_path = url('storage/attachments/'.$attachment);
            if ($attachment_type == 'image') {
                $attachment_with_download_url = '<a target="__blank" href="'.$attachment_path.'"><img src="'.$attachment_path.'"></a>';
            } else {
                $attachment_with_download_url = '<a target="__blank" href="'.$attachment_path.'"><img class="d-img" src="'.asset("assets/img/download.png").'" alt="">'.$attachment.'</a>';
            }
        }

        $msg->file = [$attachment, $attachment_title, $attachment_type, $attachment_path,$attachment_with_download_url];
        $msg->time = $msg->created_at->diffForHumans();
        $msg->sender_name = !empty($msg->sender_id) ? $msg->sender_user->first_name.' '.$msg->sender_user->last_name : '';
        $msg->sender_username = !empty($msg->sender_id) ? $msg->sender_user->username : '';
        $msg->receiver_name = !empty($msg->receiver_id) ? $msg->receiver_user->first_name.' '.$msg->receiver_user->last_name : '';
        $msg->receiver_username = !empty($msg->receiver_id) ? $msg->receiver_user->username : '';
        $msg->receiver_image = !empty($msg->receiver_id) ? show_user_image_path($msg->receiver_user->photo) : '';
        $msg->sender_image = !empty($msg->sender_id) ? show_user_image_path($msg->sender_user->photo) : '';
        return $msg;
    }
    // check file
    public function checkFileAtSendMsg($request)
    {
        try {
            $data['attachment_title'] = null;
            $data['attachment'] = null;
            // if there is attachment [file]
            if (!empty($request->file)) {
                // allowed extensions
                $allowed_images = $this->getAllowedImages();
                $allowed_files  = $this->getAllowedFiles();
                $allowed        = array_merge($allowed_images, $allowed_files);

                $file = $request->file('file');
                // check file size
                if ($file->getSize() < $this->getMaxUploadSize()) {
                    if (in_array($file->getClientOriginalExtension(), $allowed)) {
                        // get attachment name
                        $attachment_title = $file->getClientOriginalName();
                        // upload attachment and store the new name
                        $attachment = Str::uuid() . "." . $file->getClientOriginalExtension();
                        $file->storeAs("attachments" , $attachment);
                        $data['attachment_title'] = $attachment_title;
                        $data['attachment'] = $attachment;
                        $response = [
                            'success' => true,
                            'message' => __('File found'),
                            'data' => $data
                        ];
                        return $response;
                    } else {
                        $response = [
                            'success' => false,
                            'message' => __('File extension not allowed!'),
                            'data' => []
                        ];
                        return $response;
                    }
                } else {
                    $response = [
                        'success' => false,
                        'message' => __('File size you are trying to upload is too large!'),
                        'data' => []
                    ];
                    return $response;
                }
            } else {
                $response = ['success' => true, 'message' => __('Success'), 'data' => []];
            }
        } catch (\Exception $e) {
            $this->logger->log('checkFileAtSendMsg', $e->getMessage());
            $response = ['success' => false, 'message' => __('File size should not be greater than 2MB'),'data' => $e->getMessage()];
        }
        return $response;
    }

    /**
     * This method returns the allowed image extensions
     * to attach with the message.
     *
     * @return array
     */
    public function getAllowedImages(){
        return ['png','jpg','jpeg','gif'];
    }

    /**
     * This method returns the allowed file extensions
     * to attach with the message.
     *
     * @return array
     */
    public function getAllowedFiles(){
        return ['zip','rar','txt'];
    }

    /**
     * Get max file's upload size in MB.
     *
     * @return int
     */
    public function getMaxUploadSize(){
        return 5 * 1048576;
    }
}
