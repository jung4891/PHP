<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Board extends CI_Controller {
	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );

		$this->load->Model(array('sales/STC_Board', 'STC_Common'));
	}

	function ckeditor_image_upload() {
		try {
			$permit_size = 10485760;
			$permit_exts = array('jpg', 'jpeg', 'png');

			$doc_root = $_SERVER['DOCUMENT_ROOT'];

			$default_dir = '/uploads/ckeditor/'.date('Ymd').'/';
			$upload_dir = $doc_root.$dafault_dir;

			if (!is_dir($upload_dir)) {
				mkdir($upload_dir, 0707);
			}
			$files = $_FILES['upload'];
			if ($files['tmp_name']) {
				$tmp_name = $tmp_file = array();
				$exp_name = pathinfo($files['name']);

				$tmp_file['name'] = preg_replace('/\s+/', '', strtolower($exp_name['filename']));
				$tmp_file['ext'] = strtolower($exp_name['extension']);
				$tmp_file['size'] = $files['size'];

				$upload_name = uniqid().'_'.time().'.'.$tmp_file['ext'];
				if (is_file($upload_dir.$upload_name)) {
					while (!is_file($upload_dir.$upload_name)) {
						$upload_name = uniqid().'_'.time().'.'.$tmp_file['ext'];
					}
				}
				if (!in_array($tmp_file['ext'], $permit_exts)) throw new Exception('이미지 파일만 첨부 할 수 있습니다.('.(implode(', ', $permit_exts)).')');

				$data = array(
					'ori_name'    => $tmp_file['name'].'.'.$tmp_file['ext'],
					'tmp_name'    => $files['tmp_name'],
					'up_name'     => $upload_name,
					'error'       => $files['error'],
					'size'        => $files['size'],
					'path'        => $default_dir,
					'type'        => $files['type'],
					'img'         => $default_dir.$upload_name,
					'my_thumb_id' => explode('.'.$upload_name)[0]
				);

				move_uploaded_file($data['tmp_name'], $upload_dir.$data['up_name']);

				echo '{"filename" : "'.$data['up_name'].'", "uploaded" : 1, "url":"'.$default_dir.$data['up_name'].'"}';
			} else {
				throw new Exception('업로드된 파일이 없습니다.');
			}
		} catch (Exception $e) {
			echo '{"uploaded": 0, "error": {"message": "'.$e->getMessage().'"}}';
		}
	}

	function notice_list() {
		if ( $this->id === null ) {
			redirect('account');
		}

		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		} else {
			$cur_page = 0;
		}
		$no_page_list = 10;

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		} else {
			$search_keyword = '';
		}

		if(isset($_GET['search1'])) {
			$search1 = $_GET['search1'];
		} else {
			$search1 = '';
		}

		if(isset($_GET['search2'])) {
			$search2 = $_GET['search2'];
		} else {
			$search2 = '';
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		$data['search2'] = $search2;

		if ($cur_page <= 0) {
			$cur_page = 1;
		}

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Board->notice_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Board->notice_list_count($search_keyword, $search1, $search2)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

		$total_page = 1;

		if( $data['count'] % $no_page_list == 0 ) {
			$total_page = floor( ( $data['count'] ) / $no_page_list );
		} else {
			$total_page = floor( ( $data['count'] / $no_page_list + 1 ) );
		}

		$start_page = floor( ( $cur_page - 1 ) / 10 ) * 10 + 1;
		$end_page = 0;

		if( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ) {
			$end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
		} else {
			$end_page = $total_page;
		}

		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;

		$this->load->view( 'sales/notice_list', $data );
	}

	function notice_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');

		$fdata = $this->STC_Board->notice_file($seq, $filelcname);

		if(!isset($fdata['file_changename'])) {
			alert('파일 정보가 존재하지 않습니다.');
		}
	}

	function notice_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');

		$fdata = $this->STC_Board->notice_file($seq, $filelcname);

		if(!isset($fdata['file_changename'])) {
			alert('파일 정보가 존재하지 않습니다.');
		} else {
			$fdata2 = $this->STC_Board->notice_filedel($seq);
			if($fdata2) {
				unlink('/var/www/html/stc/html/upload/sales/notice/'.$fdata['file_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/sales/board/notice_view?seq='.$seq.'&mode=modify');
		}
	}

	function notice_input_action() {
		if ( $this->id === null ) {
			redirect('account');
		}

		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;
		$ext = substr(strrchr($cname,'.'),1);
		$ext = strtolower($ext);
	}

	if ($csize > 0 && $cname) {
		if ($csize > 104857600) {
			echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
			exit;
		}

		if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
			echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
			exit;
		}

		$upload_dir = '/var/www/html/stc/misc/upload/sales/notice';

		$conf_file['upload_path'] = $upload_dir;
		$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
		$conf_file['overwrite'] = false;
		$conf_file['encrypt_name'] = true;
		$conf_file['remove_spaces'] = true;

		$this->load->library( 'upload', $conf_file );

		if( $this->upload->do_upload('cfile') ) {
			$data = array('upload_data' => $this->upload->data());
			$filename = $data['upload_data']['orig_name'];
			$lcfilename = $data['upload_data']['file_name'];
		} else {
			alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
			exit;
		}

		$data = array(
			'category_code'   => $this->input->post('category_code'),
			'subject'         => addslashes($this->input->post('subject')),
			'contents'        => $this->input->post('contents'),
			'user_id'         => $this->id,
			'user_name'       => $this->name,
			'file_changename' => $lcfilename,
			'file_realname'   => $filename,
			'insert_date'     => date('Y-m-d H:i:s'),
			'update_date'     => date('Y-m-d H:i:s')
		);
	} else {
		$data = array(
			'category_code' => $this->input->post('category_code'),
			'subject'       => addslashes($this->input->post('subject')),
			'contents'      => $this->input->post('contents'),
			'user_id'       => $this->id,
			'user_name'     => $this->name.
			'insert_date'   => date('Y-m-d H:i:s'),
			'update_date'   => date('Y-m-d H:i:s')
		);
	}

	if ($seq == null) {
		$result = $this->STC_Board->notice_insert($data, $mode = 0);
	} else {
		$result = $this->STC_Board->notice_insert($data, $mode = 1, $seq);
	}

	if($result) {
		echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/board/notice_list'</script>";
	} else {
		echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
	}

}

class customException extends Exception {
	public function errorMessage() {
		$errorMsg = $this->getMessage().' is not a valid E-Mail address.';
		return $errorMsg;
	}
}

$email = 'hbhwang@durianit.co.kr';

public function forgot() {
	$this->confirm_user_logged_out();

	$email_value = $this->input->post('email');

	$flash_message = $this->session->flashdata('flash_message');
	$message = isset($flach_message) ? $flash_message : '';

	if(!empty($email_value)) {
		$this->form_validation->set_rules(
			'email', lang('email_address'), $this->email_validation_rules.'|required'
		);

		$form_validated = $this->form_validation->run();
		if ($form_validated) {
			if ($this->user_model->does_user_exist($email_value)) {
				$alert_data = [
					'title' => lang('password_reset_sent_title'),
					'message' => lang('password_reset_sent_body'),
				];
				$message = $this->load->view('alerts/success_title', $alert_data, TRUE);
				$this->send_password_reset_email($email_value);
			}
		} else {
			$alert_data = [
				'message' => lang('error_occurred'),
			];
			$message = $this->load->view('alerts/error.php', $alert_data, TRUE);
		}
	}
	$this->get_forgot_view($email_value, $message);
}

public function reset_password($encoded_token = '') {
	$this->confirm_user_logged_out();

	$token_valid = FALSE;

	if (!empty($encoded_token)) {
		$decoded_token = base_64_decode(urldecode($encoded_token));
		$token_valid = $this->user_model->is_token_valid($decoded_token);
		$this->session->set_flashdata('flash_token', $encoded_token);
	}

	if ($token_valid) {
		$password_value = $this->input->post('password');
		$confirm_password_value = $this->input->post('confirm-pasword');
		$message = '';

		$user_data = $this->user_model->get_user_from_token($decoded_token);
		$user_id = $user_data['id'];
		$user_email = $user_data['email'];

		if (!empty($password_value) && !empty($confirm_password_value)) {
			$this->form_validation->set_rules(
				'password', lang('new_password'), $this->password_validation_rules.'|required'
			);
			$this->form_validation->set_rules(
				'confirm-password', lang('confirm_new_password'), 'trim|required|matches[password]'
			);

			$form_validated = $this->form_validation->run();

			$alert_data = [
				'message' => lang('error_occurred'),
			];
			$message = $this->load->view('alerts/error.php', $alert_data, TRUE);

			if ($form_validated) {
				$data = [
					'id'       => $user_id,
					'email'    => $user_email,
					'password' => $password_value,
				];

				$user_exists = $this->user_model->does_user_exist($data['email']);

				if ($user_exists > 0) {
					$is_user_updated = $this->user_model->update_password($data);

					if ($is_user_updated) {
						$this->session->set_flashdata('temp_email', $data['email']);

						$alert_data = [
							'title'    => lang('password_updated'),
							'message'  => lang('password_updated_alert_body'),
							'url'      => base_url('user/login'),
							'url_text' => lang('login_now')
						];
						$message = $this->load->view('alerts/success_title_link.php', $alert_data, TRUE);

						$this->user_model->remove_token($decoded_token);

						$password_value = '';
						$confirm_password_value = '';
					}
				}
			}
		}
		$this->get_password_reset_view($password_value, $confirm_password_value, $message);
	} else {
		$alert_data = [
			'title' => lang('oops'),
			'message' => lang('expired_password_link_alert_body'),
		];
		$this->session->set_flashdata('flash_message', $this->load->view('alerts/error_title.php', $alert_data, TRUE));
		redirect('user/forgot');
	}
}

public function register() {
	$this->confirm_user_logged_out();

	$email_value = $this->input->post('email');
	$password_value = $this->input->post('password');
	$confirm_password_value = $this->input->post('confirm-password');
	$message = '';

	if(!empty($email_value) && !empty($password_value) && !empty($confirm_password_value)) {
		$this->form_validation->set_rules(
			'email', lang('email_address'), $this->email_validation_rules.'|required'
		);
		$this->form_validation->set_rules(
			'password', lang('password'), $this->password_validation_rules.'|required'
		);
		$this->form_validation->set_rules(
			'confirm-password', lang('confirm_password'), 'trim|required|matches[password]'
		);

		$form_validated = $this->form_validation->run();

		$alert_data = [
			'message' => lang('error_occurred'),
		];
		$message = $this->load->view('alerts/error.php', $alert_data, TRUE);

		if ($form_validated) {
			$data = [
				'email'    => $email_value,
				'password' => $password_value
			];
			$user_exists = $this->user_model->does_user_exist($data['email']);

			if (!$user_exists) {
				$is_user_created = $this->user_model->create($data);

				if ($is_user_created > 0) {
					$alert_data = [
						'title'    => lang('registered_alert_title'),
						'message'  => lang('registered_alert_body'),
						'url'      => base_url('user/login'),
						'url_text' => lang('login_now')
					];
					$message = $this->laod->view('alerts/success_title_link.php', $alert_data, TRUE);

					$this->session->set_flashdata('temp_email', $data['email']);

					$email_value = '';
					$password_value = '';
					$confirm_password_value = '';
				}
			}
		}
	}
	$this->get_register_view(
		$email_value, $password_value, $confirm_password_value, $message
	);
}

public function login() {
	$this->confirm_user_logged_out();

	$provided_email = $this->session->flashdata('temp_email');

	$email_value = isset($provided_email) ? $provided_email : $this->input->post('email');
	$password_value = $this->input->post('password');
	$message = '';

	if (! empty($email_value) && !empty($password_value)) {
		$this->form_validation->set_rules(
			'email', lang('email_address'), $this->email_validation_rules.'|required'
		);
		$this->form_validation->set_rules(
			'password', lang('password'), $this->password_validation_rules.'|required'
		);

		$form_validated = $this->form_validation->run();
		if ($form_validated) {
			$data = [
				'email'    => $email_value,
				'password' => $password_value
			];

			$user_id = $this->user_model->confirm_login($data);
			if ($user_id) {
				$this->user_model->create_user_session($user_id);
				redirect('user/home', 'refresh');
			} else {
				$alert_data = [
					'title'   => lang('login_error_alert_title'),
					'message' => lang('login_error_alert_body')
				];
				$message = $this->load->view('alerts/error_title.php', $alert_data, TRUE);
			}
		} else {
			$alert_data = [
				'title'   => lang('login_error_alert_title'),
				'message' => lang('login_error_alert_body'),
			];
			$message = $this->load->view('alerts/error_title.php', $alert_data, TRUE);
		}
	}
	$this->get_login_view($email_value, $password_value, $message);
}

public function logout() {
	$this->user_model->destroy_user_session();

	redirect('user/index', 'refresh');
}

private function get_password_reset_view($password_value = '', $confirm_password_value = '', $message = '') {
	$password_input = $this->get_password_input_field($password_value);

	$confirm_password_input = $this->get_password_input_field($confirm_password_value, 'confirm-password');

	$form_data = [
		'message' => $message,
		'form_tag' => form_open('user/reset_password/'.$this->session->flashdata('flash_token'), [
			'id' => 'password-reset-form',
		]),
		'submit_label' => lang('change_password'),
	];

	$form_data = $this->add_form_input_data(
		$form_data, 'password', lang('new_password'), $password_input, $password_value, lang('character_length_3')
	);
	$form_data = $this->add_form_input_data(
		$form_data, 'confirm_password', lang('confirm_new_password'), $confirm_password_input, $confirm_password_value, lang('must_match_')
	);
}

try {
	try {
		if(strpos($email, 'example') !== FALSE) {
			throw new Exception($email);
		}
	}
	catch(Exception $e) {
		throw new customException($email);
	}
}

catch(customException $e) {
	echo $e->errorMessage();
}

class MyAttribute {
	public $value;

	public function __construct($value) {
		$this->value = $value;
	}
}

function dumpAttributeData($reflection) {
	$attributes = $reflection->getAttributes();
}

class Qrtools {
	public static function binarize($frame) {
		$len = count($frame);
		foreach($frame as &$frameLine) {
			for($i=0; $i<$len; $i++) {
				$frameLine[$i] = (ord($frameLine[$i])&1)?'1':'0';
			}
		}
		return $frame;
	}

	public static function tcpdfBarcodeArray($code, $mode = 'QR,L', $tcPdVersion = '4.5.037') {
		$barcode_array = array();

		if (!is_array($mode)) {
			$mode = explode(',',$mode);
		}

		$eccLevel = 'L';

		if (count($mode) > 1) {
			$eccLevel = $mode[1];
		}

		$qrTab = QRcode::text($code, false, $eccLevel);
		$size = count($qrTab);

		$barcode_array['num_rows'] = $size;
		$barcode_array['num_cols'] = $size;
		$barcode_array['bcode'] = array();

		foreach ($qrTab as $line) {
			$arrAdd = array();
			foreach(str_split($line) as $char) {
				$arrAdd[] = ($char=='1')?1:0;
			}
			$barcode_array['bcode'][] = $arrAdd;
		}

		return $barcode_array;
	}

	public static function clearCache() {
		self::$frames = array();
	}

	public static function buildCache() {
		QRtools::markTime('befor_build_cache');
		$mast = new QRmask();

		for($a=1; $a <= QRSPEC_VERSION_MAX; $a++) {
			$frame = QRspec::newFrame($a);
			if(QR_IMAGE) {
				$fileName = QR_CACHE_DIR.'frame_'.$a.'.png';
				QRimage::png(self::binarize($frame), $fileName, 1, 0);
			}
		}
	}
}
 ?>
