<?php

namespace App\Models;


class Shareholder extends Model
{


    static $table = 'EGM';
    protected static $primaryKey = 'ID';
    protected static $readable = ['n_security', 'i_holder', 'i_holder_type', 'i_title', 'n_title', 'n_first', 'n_last', 'a_holder_1', 'a_holder_2', 'i_zip', 'Phone', 'c_tax', 'i_tax', 'q_share', 'q_share_p', 'q_cheque', 'tax', 'i_cheque', 'f_status', 'reftype', 'I_ref', 'n_tax', 'end', 'Attended', 'Shares_Attended', 'P_Shares_Attended', 'Proxy', 'Proxy_name', 'BallotPaperPrinted', 'Custodian', 'USER_ID', 'Registered_Time', 'Out_Time', 'Group_id', 'org_q_share', 'org_q_share_p', 'serial', 'coupon1_claimed', 'coupon2_claimed', 'coupon3_claimed', 'feedback_submitted', 'factory_visit_interested', 'name_on_ballot', 'org_n_first', 'org_n_last', 'org_i_ref', 'ProxyType', 'OTP', 'OTP_TIME', 'e_mail', 'm_phone', 'username', 'password', 'ApprovedForOnline', 'lastLogin', 'status', 'active', 'IPAddress', 'Email_sent', 'doc_received', 'jitsiid', 'proxy_I_ref', 'BlackList', 'shares_to_attend_for_proxy_c', 'accepted_terms', 'follow_up_required', 'email_for_invitation'
    ];


    public static function readable(){
        return static::$readable;
    }
}
