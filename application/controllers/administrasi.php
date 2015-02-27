<?php 

class administrasi extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$method = $this->uri->segment(2);

		if( strtolower( $method ) == "login" ){
			if( check_adm_login() ){
				redirect("administrasi/index");
			}
		}else{

			if( check_adm_login() == FALSE ){
				redirect("administrasi/login");
			}
		}


	}

	public function index(){
		$data['output'] = $this->load->view('adm/beranda',array(),true);
		$this->load->view("layout/layout_backend",$data);
	}

	public function login(){
		$this->load->view("layout/layout_login_backend");
	}


	public function kriteria(){

		$this->load->library('parser');

		$data['kriterias']	=	$this->db->query("SELECT * FROM kriteria")->result();
		$data['output'] 	= 	$this->load->view("adm/kriteria/list",$data,true);
		$data['skript']		=	$this->parser->parse('scripts/script_criteria.js',array(),true);

		$this->load->view('layout/layout_backend',$data);

	}

	public function tambah_kriteria(){
		$data['parent_kriteria'] = $this->db->query("SELECT * FROM kriteria where parent_kriteria is NULL");
		$data['output'] 	= 	$this->load->view("adm/kriteria/add",$data,true);
		$this->load->view('layout/layout_backend',$data);		
	}

	public function edit_kriteria($kode){
		$id = $this->db->query("SELECT id_kriteria FROM kriteria WHERE kode_kriteria='$kode' LIMIT 1")->row();
		$id =$id->id_kriteria;

		$data['kriteria']   = 	$this->db->query("SELECT * FROM kriteria where kode_kriteria = '$kode' or id_kriteria = '$kode' limit 1")->row();			
		$data['parent_kriteria'] = $this->db->query("SELECT * FROM kriteria where parent_kriteria is NULL");
		$data['intensitas']=	$this->db->query("SELECT * FROM intensitas where id_kriteria='$id'");

		$data['output'] 	= 	$this->load->view("adm/kriteria/add",$data,true);

		$this->load->view('layout/layout_backend',$data);		
	}

	public function simpan_kriteria( $sub=false ){

		$this->load->library("form_validation");

		$redirect_link = 'administrasi/tambah_kriteria';

		$config = array(
               array(
                     'field'   => 'kode_kriteria', 
                     'label'   => 'Kode Kriteria', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'nama_kriteria', 
                     'label'   => 'nama_kriteria', 
                     'rules'   => 'required'
                  ),
		);

		$this->form_validation->set_rules( $config );

		if( $this->form_validation->run() == FALSE ){
			$this->session->set_flashdata('error',validation_errors());
			redirect( $redirect_link );
		}else{

			$kode_kriteria = $this->input->post('kode_kriteria',true);
			$parent_kriteria = $this->input->post('parent_kriteria',true);
			$nama_kriteria = $this->input->post('nama_kriteria',true);
			$keterangan    = $this->input->post('keterangan',true);
			
			if($parent_kriteria==''){
				$parent_kriteria=NULL;
			}


			$kriteria = [
				'kode_kriteria' => $kode_kriteria,
				'nama_kriteria' => $nama_kriteria,
				'keterangan'	=> $keterangan,
				'parent_kriteria'=>$parent_kriteria,
				];
			

			$kriterias = $this->db->query("SELECT id_kriteria FROM kriteria")->result();


			$this->db->trans_start();  //start transaction
			
			$this->db->insert("kriteria",$kriteria);
			
			if(count($kriterias)>0){
				$i=0;
				foreach ($kriterias as $k) {
					$perbandingan_berpasangan[$i]=[
						'baris'=>$this->db->insert_id(),
						'kolom'=>$k->id_kriteria,
						'nama'=>$this->db->insert_id()."_".$k->id_kriteria,
						'nilai'=>1,
						'parent_kriteria'=>$parent_kriteria
					];
					$i++;
					$perbandingan_berpasangan[$i]=[
						'baris'=>$k->id_kriteria,
						'kolom'=>$this->db->insert_id(),
						'nama'=>$k->id_kriteria."_".$this->db->insert_id(),
						'nilai'=>1,
						'parent_kriteria'=>$parent_kriteria
					];
					$i++;
				}
			} //end if

				$perbandingan_berpasangan[$i]=[
						'baris'=>$this->db->insert_id(),
						'kolom'=>$this->db->insert_id(),
						'nama'=>$this->db->insert_id()."_".$this->db->insert_id(),
						'nilai'=>1
				];

			$this->db->insert_batch('perbandingan_berpasangan',$perbandingan_berpasangan);


			$this->db->trans_complete();  //end transaction

			if ($this->db->trans_status() === FALSE){
				$messages = "Kriteria gagal disimpan.";
				$this->session->set_flashdata('error',$messages);
				redirect( $redirect_link );
			}else{
				$messages = "Kriteria berhasil disimpan.";
				$this->session->set_flashdata('success',$messages);
				redirect( $redirect_link );
			}


		}

	}

	public function update_kriteria(){

		$this->load->library("form_validation");

		$config = array(
               array(
                     'field'   => 'nama_kriteria', 
                     'label'   => 'nama_kriteria', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'kode_kriteria', 
                     'label'   => 'kode_kriteria', 
                     'rules'   => 'required'
                  ),
		);

		$id_kriteria = $this->input->post('k_krit',true);
		$nama_kriteria = $this->input->post('nama_kriteria',true);
		$keterangan    = $this->input->post('keterangan',true);
		$parent_kriteria = $this->input->post('parent_kriteria',true);
		$sumber_tabel	= $this->input->post('sumber_tabel',true);
		$sumber_field	= $this->input->post('sumber_field',true);
		$kode_kriteria = $this->input->post('kode_kriteria',true);
		$kode_kriteria_lama = $this->input->post('kode_kriteria_lama',true);

		if($parent_kriteria==''){
				$parent_kriteria=NULL;
		}


		$this->form_validation->set_rules( $config );

		if( $this->form_validation->run() == FALSE ){
			$this->session->set_flashdata('error',validation_errors());
			redirect('administrasi/edit_kriteria/'.$kode_kriteria_lama);
		}else{
		
			$kriteria = [
				'kode_kriteria' => $kode_kriteria,
				'nama_kriteria' => $nama_kriteria,
				'keterangan'	=> $keterangan,
				'parent_kriteria'=>$parent_kriteria,
			];

			$this->db->trans_start();  //start transaction

			$this->db->where('id_kriteria',$id_kriteria);
			$this->db->update("kriteria",$kriteria);

			$this->db->trans_complete();  //end transaction

			if ($this->db->trans_status() === FALSE){
				$messages = "Kriteria gagal diubah.";
				$this->session->set_flashdata('error',$messages);
				redirect('administrasi/edit_kriteria/'.$kode_kriteria_lama);	
	
			}else{
				$messages = "Kriteria berhasil diubah.";
				$this->session->set_flashdata('success',$messages);
				redirect('administrasi/edit_kriteria/'.$kode_kriteria_lama);				
	
			}

		}

	}
	public function lihat_kriteria($kode){


		$data['kriteria'] 		= $this->db->query("select * from kriteria where kode_kriteria = '$kode' limit 1")->row();
		$data['subkriterias']	= $this->db->query("SELECT * FROM kriteria where parent_kriteria = ".$data['kriteria']->id_kriteria."")->result_array();
		$data['output'] 		= $this->load->view('adm/kriteria/view',$data,true);
		$data['skript']			= $this->load->view('scripts/script_criteria.js',array(),true);

		$this->load->view('layout/layout_backend',$data);

	}

	public function hapus_kriteria($kode){
		
		$this->db->where('kode_kriteria', $kode);
		 
		return ( $this->db->delete('kriteria') );

	}

	public function pair_comparison(){

		$parent = $this->uri->segment(3);
		
		$where ="parent_kriteria = '$parent'";

		if($parent==''){
			$where="parent_kriteria is NULL";
		}

		$data['kriteria'] = $this->db->query("SELECT * FROM kriteria WHERE $where")->result();
		$data['perbandingan_berpasangan'] = $this->db->query("SELECT * FROM perbandingan_berpasangan WHERE $where ORDER BY baris,kolom")->result();
		$data['output'] = $this->load->view('adm/pair_comparison/form',$data,true);
		$data['skript']			= $this->load->view('adm/pair_comparison/hitung.js',$data,true);
		$this->load->view('layout/layout_backend',$data);

	}

	

	


}