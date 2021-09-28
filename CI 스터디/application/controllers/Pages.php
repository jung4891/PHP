<?php
class Pages extends CI_Controller {

  public function view($page = 'home')
  {
    if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
    {
            // Whoops, we don't have a page for that!
            show_404();
    }

    $data['title'] = ucfirst($page); // Capitalize the first letter
    $data['test'] = 'This is Test~!';

    $this->load->view('templates/header', $data);
    $this->load->view('pages/'.$page, $data);
    $this->load->view('templates/footer', $data);
    // the value of $data['title'] in the controller is equivalent to $title in the view.

    echo '<br> 테스트입니다. ';
  }
  /*
    http://example.com/index.php/pages/view
    http://example.com/index.php/pages/view/about
    http://example.com/[controller-class]/[controller-method]/[arguments]
  */

  // public function index()
	// {
	// 	// $this->load->view('welcome_message');
	// }

}
