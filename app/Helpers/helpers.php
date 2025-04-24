<?php
// REMOVE THIS CODE FROM YOUR VIEW FILE
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'pending':
            return 'warning';
        case 'processing':
            return 'info';
        case 'shipped':
            return 'success';
        case 'completed':
            return 'primary';
        default:
            return 'secondary';
    }
}
?>
