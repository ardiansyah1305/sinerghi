<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'title',
        'message',
        'reference_id',
        'reference_type',
        'is_read',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Get unread notifications for a user
     *
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getUnreadNotifications($userId, $limit = 10)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    /**
     * Get all notifications for a user
     *
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getAllNotifications($userId, $limit = 20)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    /**
     * Mark notification as read
     *
     * @param int $notificationId
     * @return bool
     */
    public function markAsRead($notificationId)
    {
        return $this->update($notificationId, ['is_read' => 1]);
    }

    /**
     * Mark all notifications as read for a user
     *
     * @param int $userId
     * @return bool
     */
    public function markAllAsRead($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->set(['is_read' => 1])
                    ->update();
    }

    /**
     * Create a new notification for a proposal
     *
     * @param int $userId
     * @param int $proposalId
     * @param string $unitName
     * @param string $month
     * @return bool
     */
    public function createProposalNotification($userId, $proposalId, $unitName, $month)
    {
        $data = [
            'user_id' => $userId,
            'title' => 'Usulan Baru',
            'message' => "Usulan baru dari {$unitName} untuk bulan {$month} memerlukan persetujuan Anda.",
            'reference_id' => $proposalId,
            'reference_type' => 'proposal',
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->insert($data);
    }
}
