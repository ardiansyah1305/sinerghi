<?php

if (!function_exists('get_status_label')) {
    /**
     * Get the status label based on the status code
     *
     * @param int $status_code The status code
     * @return string The status label
     */
    function get_status_label($status_code) {
        switch ((int)$status_code) {
            case 0:
                return 'Draft';
            case 1:
                return 'Menunggu Persetujuan';
            case 2:
                return 'Disetujui';
            case 3:
                return 'Ditolak';
            case 4:
                return 'Dibatalkan';
            default:
                return 'Unknown';
        }
    }
}

if (!function_exists('get_status_class')) {
    /**
     * Get the Bootstrap class for the status
     *
     * @param int $status_code The status code
     * @return string The Bootstrap class
     */
    function get_status_class($status_code) {
        switch ((int)$status_code) {
            case 0:
                return 'bg-warning text-dark';
            case 1:
                return 'bg-info';
            case 2:
                return 'bg-success';
            case 3:
                return 'bg-danger';
            case 4:
                return 'bg-danger';
            default:
                return 'bg-secondary';
        }
    }
}
