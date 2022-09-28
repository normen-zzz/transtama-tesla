<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Frontend
{

	protected $_CI;

	function __construct()
	{
		$this->_CI = &get_instance();
	}

	function display($template, $data = null)
	{
		$data['_content'] = $this->_CI->load->view($template, $data, true);
		$data['metas'] = array(
			'title' =>  'Cool Unida',
			'description' => 'E-learning Universitas Djuanda, Cool Unida, Unida Cool',
			'keywords' => 'Universitas Djuanda, Unida cool, Unida Bogor, LMS Unida, Kampus Bertauhid, E-learning Unida Bogor, E-Learning Keren, Cool unida'
		);

		$this->_CI->load->view('templates/front/template', $data);
	}
}
