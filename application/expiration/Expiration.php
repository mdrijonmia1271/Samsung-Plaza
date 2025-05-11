<?php
class Expiration {
	protected $registraction_date, $expiration_date, $last_pay_date = null;

	public function __construct($regi=null, $expire=null)
	{
		date_default_timezone_set("Asia/Dhaka");
		$this->registraction_date = $regi;
		$this->expiration_date    = $expire;
	}

	public function handle($id=null){
		$registraction_date = $this->registraction_date;
		$expiration_date 	= $this->expiration_date;

		if($registraction_date && $expiration_date && $id){
			/*
			* ***********************
			*  Create Date Time
			* ***********************
			*/
			$registered = date_create($registraction_date);
			$expire 	= date_create($expiration_date);
			/*
			* ***********************
			*  Date Difference of
			*  Between Registerd
			*  And expire
			* ***********************
			*/
			$diff       = date_diff($registered, $expire);
			$diff_day	= $diff->format("%a");
			/*
			* ***********************
			*  Count How Much Year
			*  Is Pass
			* ***********************
			*/
			$passing_year_count	= (date('Y') - date('Y', strtotime($registraction_date)));
			/*
			* ***********************
			*  Dynamic Expire Date
			* ***********************
			*/
			$expire_date = date('Y-m-d', strtotime($registraction_date." +".(($passing_year_count == 0 ? 1 : $passing_year_count) * $diff_day).'day'));
			/*
			* ***********************
			*  Count Here We Have 
			*  How Much Days
			* ***********************
			*/
			$passing_day = date_diff(date_create(date('Y-m-d')), date_create($expire_date))->format("%r%a");
			$has_day 	 = 0;
			$is_day 	 = false;

			/* Filtering */
			if($passing_day >= 0){
				$has_day = $passing_day;
				$is_day  = true;
			}
			/*
			* ***************************
			*  Alert From After 7 days
			* **************************
			*/
			if($is_day && $has_day < 8)
			{
				$message = "সম্মানিত গ্রাহক, আপনার সফটওয়ার/ ওয়েবসাইট এর ডোমেইন এবং হোস্টিং এর নবায়ন এর শেষ তারিখ ".($expire_date)." । নির্বিগ্ন সেবা পেতে নির্ধারিত সময়ের মধ্যে ডোমেইন এবং হোস্টিং নবায়ন করার জন্য মোটাসফট কতৃপক্ষের সাথে যোগাযোগ করার জন্য অনুরোধ করা হচ্ছে । ধন্যবাদ । \nমোবাইল – ০১৭১০-৫১১২৪১";
				$content = "
					<script>
						window.addEventListener('load', ()=>{
							var dom = document.querySelector('".($id)."');
							if(dom){
								var div = document.createElement('div');
								content = `<div class='alert alert-warning' style='margin-bottom:0;'><button class='close' onclick='console.log(this.parentElement.parentElement.removeChild(this.parentElement))'><i class='fa fa-close'></i></button><div class='content'> <div style='margin-bottom:5px;'><strong>Warning!</strong><br></div><div>".($message)."</div></div></div></div>`;
								div.innerHTML = content;
								dom.prepend(div);
							}
						});
					</script>
				";
				if($this->last_pay_date == null){
					echo $content;
				}
				else if(strtotime($this->last_pay_date) < strtotime(date('Y-m-d').' -7day')){
					echo $content;
				}

			}
		}
		else{
			return false;
		}
	}

	public function payDate($date){
		$this->last_pay_date = $date;
	}
}
