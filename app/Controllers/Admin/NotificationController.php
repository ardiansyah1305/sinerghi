<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;

class NotificationController extends BaseController
{
    use ResponseTrait;
    
    protected $notificationModel;
    
    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }
    
    /**
     * Get unread notifications for the logged-in user
     */
    public function getUnread()
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return $this->failUnauthorized('User not authenticated');
        }
        
        $notifications = $this->notificationModel->getUnreadNotifications($userId);
        
        return $this->respond([
            'status' => 'success',
            'data' => $notifications,
            'count' => count($notifications)
        ]);
    }
    
    /**
     * Get all notifications for the logged-in user
     */
    public function getAll()
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return $this->failUnauthorized('User not authenticated');
        }
        
        $notifications = $this->notificationModel->getAllNotifications($userId);
        
        return $this->respond([
            'status' => 'success',
            'data' => $notifications
        ]);
    }
    
    /**
     * Mark a notification as read
     */
    public function markAsRead($id = null)
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return $this->failUnauthorized('User not authenticated');
        }
        
        if (!$id) {
            return $this->fail('Notification ID is required');
        }
        
        // Verify the notification belongs to the user
        $notification = $this->notificationModel->find($id);
        
        if (!$notification) {
            return $this->failNotFound('Notification not found');
        }
        
        if ($notification['user_id'] != $userId) {
            return $this->failForbidden('You do not have permission to access this notification');
        }
        
        $this->notificationModel->markAsRead($id);
        
        return $this->respondUpdated([
            'status' => 'success',
            'message' => 'Notification marked as read'
        ]);
    }
    
    /**
     * Mark all notifications as read for the logged-in user
     */
    public function markAllAsRead()
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return $this->failUnauthorized('User not authenticated');
        }
        
        $this->notificationModel->markAllAsRead($userId);
        
        return $this->respondUpdated([
            'status' => 'success',
            'message' => 'All notifications marked as read'
        ]);
    }
}
