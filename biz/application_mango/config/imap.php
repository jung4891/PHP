<?php
defined('BASEPATH') || exit('No direct script access allowed');

$config['encrypto'] = 'tls';
$config['validate'] = true;
$config['host']     = 'mail.durianit.co.kr';
$config['port']     = 143;
$config['imap_user'] = '';
$config['imap_pass'] = '';

// $config['folders'] = [
// 	'inbox'  => 'INBOX',
// 	'sent'   => 'Sent',
// 	'trash'  => 'Trash',
// 	'spam'   => 'Spam',
// 	'drafts' => 'Drafts',
// ];
//
// $config['expunge_on_disconnect'] = false;
//
// $config['cache'] = [
// 	'active'     => false,
// 	'adapter'    => 'file',
// 	'backup'     => 'file',
// 	'key_prefix' => 'imap:',
// 	'ttl'        => 60,
// ];
