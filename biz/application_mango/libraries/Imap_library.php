<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Imap_library
{

    var $CI;
    var $config;
    var $conn;
    var $headers;

    function imap($config)
    {
        $this->CI =& get_instance();
        $this->config = $config;

        $this->conn = imap_open('{mail.durianit.co.kr:143/novalidate-cert}INBOX',$this->config['imap_user'],$this->config['imap_pass']);

				echo "<script>alert('".$this->config['imap_user']."')</script>";
				echo $this->config['imap_pass'];

        if(!$this->conn)
        {
            return $this->imap_get_last_error();
        }
    }

    function imap_check()
    {
        $imap_opj = imap_check($this->conn);
        return $imap_obj;
    }

    function __imap_count_mail()
    {
        $this->headers = @imap_headers($this->conn);
        if(!empty($this->headers))
        {
            return sizeof($this->headers);
        }
        else
        {
            return $this->imap_get_last_error();
        }
    }

    function imap_get_mail_array()
    {
			$mailHeader = [];
        for($i = 1; $i < $this->__imap_count_mail() + 1; $i++)
        {
            $mailHeader[$i] = @imap_headerinfo($conn, $i);
        }

        return $mailHeader;
    }

    function imap_send_mail($to,$subject,$message,$additional_headers=NULL,$cc=NULL,$bcc=NULL,$rpath=NULL)
    {
        if(@imap_mail($to,$subject,$message,$additional_headers=NULL,$cc=NULL,$bcc=NULL,$rpath=NULL))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function imap_read_mail($mail_id)
    {
        $mail_header = imap_header($this->conn, $mail_id);
        $mail_body = imap_body($this->conn, $mail_id);

        foreach($mail_header as $mail_head)
        {
            $mail[] = $mail_head;
        }

        $mail['body'] = $mail_body;

        return $mail;
    }

    function imap_delete_mail($mail_id)
    {
        if(@imap_delete($this->conn, $mail_id))
        {
            @imap_expunge($this->conn);
            return TRUE;
        }
        else
        {
            return $this->imap_get_last_error();
        }
    }
    function imap_get_last_error()
    {
        $error = imap_last_error($this->conn);
        if(!empty($error))
        {
            return $error;
        }
        else
        {
            return NULL;
        }
    }

    function close_imap()
    {
        imap_close($this->conn);
    }
	}
?>
