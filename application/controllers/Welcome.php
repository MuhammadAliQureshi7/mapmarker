<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->helper('url');
		$this->load->view('map_view');
	}
	/*public function get_location()
	{
		$this->load->library('googlemaps');

		$address = $this->input->post('address');

		$geocoder = $this->googlemaps->GoogleMapsGeocoder($address);

		$latitude = $geocoder->getLatitude();
		$longitude = $geocoder->getLongitude();

		$data = array(
			'address' => $address,	
			'latitude' => $latitude,
			'longitude' => $longitude
		);
		$this->load->library('database');
		$this->db->insert('address', $data);

		redirect('welcome');
	}*/
	public function view_map()
	{
		$this->load->view('map');
	}
	/*public function save_location()
{
    $data = array(
        'latitude' => $this->input->post('lat'),
        'longitude' => $this->input->post('lng')
    );

    // Save the user's location to the database
	$this->load->library('database');
    $this->db->insert('address', $data);

    echo 'Location saved successfully.';
}*/
public function save_location() {
	$this->load->helper('url');
	$this->load->database();
	$data = array(
		'latitude' => $this->input->post('latitude'),
		'longitude' => $this->input->post('longitude')
	);
	
	$this->db->insert('address', $data);	
	return redirect('welcome/index');
}
public function getlocation()
{
    $address = "London united state";
    $array  = $this->get_longitude_latitude_from_adress($address);
    $latitude  = round($array['lat'], 6);
    $longitude = round($array['long'], 6);           
}
 
function get_longitude_latitude_from_adress($address){
  
$lat =  0;
$long = 0;
 
 $address = str_replace(',,', ',', $address);
 $address = str_replace(', ,', ',', $address);
 
 $address = str_replace(" ", "+", $address);
  try {
 $json = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyADwbHO4npy1NA-CWARlFal4I4A5WZ8Bao');
 $json1 = json_decode($json);
 
 if($json1->{'status'} == 'ZERO_RESULTS') {
 return [
     'lat' => 0,
     'lng' => 0
    ];
 }
 
 if(isset($json1->results)){
    
    $lat = ($json1->{'results'}[0]->{'geometry'}->{'location'}->{'lat'});
    $long = ($json1->{'results'}[0]->{'geometry'}->{'location'}->{'lng'});
  }
  } catch(exception $e) { }
 return [
 'lat' => $lat,
 'lng' => $long
 ];
}

}
