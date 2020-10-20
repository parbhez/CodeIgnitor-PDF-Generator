------------------Anchor Tag Link-------------
<a href="<?php echo base_url('apr-school-wise-student-view').'/'.$aprFinalStudentInformation->school_register_id; ?>" class="btn btn-info btn-xs active-apr-process">View Student</a>

--------------Route-----------------------
$route['school-wise-apr-pdf/(:num)'] = "APRController/schoolWiseAprPdf/$1";

------------------------APRController------------------
public function schoolWiseAprPdf($schoolId)
	{
		$userinfo = $this->session->userdata('userinfo');
		$data['schoolWiseStudentAprPdf'] = $this->db->select([
			'student_registration.*',
			'apr_process.*',
			'school_register.*',
			'class.*',
			'area.*',
		])
		->from('student_registration')
		->join('school_register','school_register.school_register_id=student_registration.school_code')
		->join('class','class.class_id=student_registration.class_id')
		->join('area','area.area_id=student_registration.area_id')
		->join('apr_process','apr_process.student_registration_id = student_registration.student_registration_id')
        ->where('apr_process.school_register_id',$schoolId)
        ->where('apr_process.status',3)
		->where('apr_process.active_inactive_apr_status',1)
		->get()->result();

		// echo "<pre>";
		// print_r($data['schoolWiseStudentAprPdf']);
		// exit();

		$this->load->library('pdf');
  		$this->pdf->load_view('Backend/apr/schoolWiseAprPdf',$data);
  		$this->pdf->setPaper('A4','portrait');
  		$this->pdf->render();
  		$this->pdf->stream("APR.pdf");
	}

	---------------------views-------------

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="<?php echo base_url() ?>/assets/style.css" />
    </head>
    <body>
        <?php if(count($schoolWiseStudentAprPdf) > 0){ ?>
        <?php foreach($schoolWiseStudentAprPdf as $schoolWiseStudentAprPdf) { ?>
        <div class="main">
            <div class="header_area">
                <h1 align="center">Student Information</h1>
            </div>
            <div class="voucher_address">
                <div class="customer_address">
                    <h2></h2>
                    <table class="table table-hover table-bordered">
                        
                        <tr>
                            <td>Student Name :</td>
                            <td><?php echo $schoolWiseStudentAprPdf->first_name; ?></td>
                        </tr>
                        <tr>
                            <td>School Name : </td>
                            <td><?php echo $schoolWiseStudentAprPdf->school_name; ?></td>
                        </tr>
                        <tr>
                            <td>Area Name : </td>
                            <td><?php echo $schoolWiseStudentAprPdf->area_name; ?></td>
                        </tr>
                        <tr>
                            <td>Start Date : </td>
                            <td><?php echo $schoolWiseStudentAprPdf->start_date; ?></td>
                        </tr>
                        <tr>
                            <td>End Date : </td>
                            <td><?php echo $schoolWiseStudentAprPdf->end_date; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer_area">
                <p align="center">Copyright By DevsZone</p>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </body>
</html>
