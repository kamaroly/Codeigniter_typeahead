<?php

Class Test extends CI_Controller
{
  	/**
	 * @author Kamaro Lambert
	 * @method return the response to ajax
	 * @name search(non-PHPdoc)
	 * @see Auth::index()
	 */
	public function search($id=null)
	{  
		//Did user select element?
		if($id==NULL):

		//Let's us suggest the user
		
		$this->db->or_like('last_name',$this->input->post('query'));
	    $this->db->or_like('first_name',$this->input->post('query'));
	    
	    //Use selected an eleement
	    elseif ($id!=NULL):
	    //let us select the element from the table based on person ID
	    $this->db->where(array('person_id'=>$id));
	     endif;
	     //Getting the query based on the above made conditions
	     
	    $query=$this->db->get('people');
	    //getting result of the query
	    $data['result']=$query->result();
	    
	    if($id==NULL): 
	    //if user is searching display the json_encode
	    echo json_encode($data['result']);
	    elseif ($id!=NULL):
	    //if user has selected an element to display then load data with the view
	    $this->load->view('test/twitter',$data);
	    endif;
	}

	function index()
	{   //Load the view at the fist time
		$this->load->view('test/twitter');
	}
}
