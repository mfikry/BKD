<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $userAccess = $ci->db->get_where('tb_users', [
            'role_id' => $role_id
        ]);

        // if ($userAccess->num_rows() < 1) {
        //     redirect('auth/blocked');
        // }
    }
}
