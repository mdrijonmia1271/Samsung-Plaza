<?php
// set site name
$config['site_name']   = 'Abc Electronics';
$config['my_database'] = 'wwwabcrent_abcelectronics';

$CI = & get_instance();
$CI->load->model('action');
$CI->load->database('default');
$total_sms = $CI->action->read_sum("recharge_sms","sms");
$config['total_sms'] = ($total_sms[0]->sms == null ? 0 : $total_sms[0]->sms);
// $config['total_sms']   = 1000;

$config['menual_date'] = "2018-01-06";

// all month
$config['months'] = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$config['all_months'] = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');

// print heading
$config['heading'] = array(
    'title' => 'Rafiq Electronics',
    'place' => 'Arafat Super Market, Zero Point, Khulna'
);


// dealer type
$config['dealer_type'] = ['RE', 'NE', 'NT'];

//bag size
$config['bag_size'] = array(
    "1"  => "1 Kg",
    "5"  => "5 Kg",
    "10" => "10 Kg",
    "20" => "20 Kg",
    "25" => "25 Kg",
    "50" => "50 Kg",
    "80" => "80 Kg"
);



//bank name
$config['banks'] = array(
    "Pubali_Bank_Ltd"             =>             "Pubali Bank Ltd",
    "Dhaka_Bank_Ltd"              =>             "Dhaka Bank Ltd",
    "Brac_Bank_Ltd"               =>             "BRAC Bank Ltd",
    "Sonali_Bank_Ltd"             =>             "Sonali Bank Ltd",
    "Rupali_Bank_Ltd"             =>             "Rupali Bank Ltd",
    "Janata_Bank_Ltd"             =>             "Janata Bank Ltd",
    "Agrani_Bank_Ltd"             =>             "Agrani Bank Ltd",
    "AB_Bank_Ltd"                 =>             "AB Bank Ltd",
    "NCC_Bank_Ltd"                =>             "NCC Bank Ltd",
    "Jamuna_Bank_Ltd"             =>             "Jamuna Bank Ltd",
    "National_Bank_Ltd"           =>             "National Bank Ltd",
    "Prime_Bank_Ltd"              =>             "Prime Bank Ltd",
    "Standard_Bank_Ltd"           =>             "Standard Bank Ltd",
    "The_City_Bank_Ltd"           =>             "The City Bank Ltd",
    "Trust_Bank_Ltd"              =>             "Trust Bank Ltd",
    "Islami_Bank_Bangladesh_Ltd"  =>             "Islami Bank Bangladesh Ltd",
    "Dutch_Bangla_Bank_Ltd"       =>             "Dutch Bangla Bank Ltd",
    "Mutual_Trust_Bank_Ltd"       =>             "Mutual Trust Bank Ltd"
);


// District
$config["district"] = array(
    "Barguna", "Barisal", "Bhola",
    "Jhalokati", "Patuakhali", "Pirojpur",
    "Bandarban", "Brahmanbaria", "Chandpur",
    "Chittagong", "Comilla", "Cox's Bazar",
    "Feni", "Khagrachhari", "Lakshmipur",
    "Noakhali", "Rangamati", "Dhaka",
    "Faridpur", "Gazipur", "Gopalganj",
    "Kishoreganj", "Madaripur", "Manikganj",
    "Munshiganj", "Narayanganj", "Narsingdi",
    "Rajbari", "Shariatpur", "Tangail",
    "Bagerhat", "Chuadanga", "Jessore",
    "Jhenaidah", "Khulna", "Kushtia",
    "Magura", "Meherpur", "Narail",
    "Satkhira", "Jamalpur", "Mymensingh",
    "Netrakona", "Sherpur", "Bogra",
    "Joypurhat", "Naogaon", "Natore",
    "Chapainawabganj", "Pabna", "Rajshahi",
    "Sirajgonj", "Dinajpur", "Gaibandha",
    "Kurigram", "Lalmonirhat", "Nilphamari",
    "Panchagarh", "Rangpur", "Thakurgaon",
    "Habiganj", "Moulvibazar", "Sunamganj",
    "Sylhet"
);

$config['md_transaction_type'] = ['Received', 'Paid'];
// Designation
$config['desigation'] = array('Director', 'Salesman', 'Manager', 'SR', 'DSR');

//unit
//$config['unit'] = array("Kg","Bag","Pcs","Gm","Mg","Ton","Mm","Cm","M","Ft","Yd","Inc");
$config['unit'] = array("Pcs","Feet","Bandle","KG","Litre");
// Cost purpose
$config['cost_purpose'] = array (
    'Admin', 'Adver', 'Agrot', 'Ban Ch', 'Bilding', 'Commi', 'Comoni', 'Conv', 'Donati', 'Elec Bil', 'Fac Exp', 'Flo Cas', 'Flo Exp', 'Fri Out', 'Fuell', 'Inco Tex', 'Jakat', 'Labary', 'Labrtory', 'Licence', 'Low', 'Mac Pur', 'R & M', 'Mar Exp', 'Ofic Exp', 'Oth Exp', 'Oth Pur', 'Duk Var', 'Priv R', 'Print', 'Salary', 'Tour', 'Wages', 'Witdron', 'Funiture', 'MadAlw', 'Picup R', 'Hon Pur', 'Bonus'
);

$config["days"] = array(
    "Saturday"  => "শনিবার",
    "Sunday"    => "রবিবার",
    "Monday"    => "সোমবার",
    "Tuesday"   => "মঙ্গলবার",
    "Wednesday" => "বুধবার",
    "Thursday"  => "বৃহস্পতিবার",
    "Friday"    => "শুক্রবার"
);

$config["days_month"] = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");

// privilege
$config['privilege'] = array('super', 'admin', 'user');

// branches
$config['branches'] = array('Branch 1', 'Branch 2', 'Branch 3', 'Branch 4', 'Branch 5');

//Developer Access
$config["developer"] = array(
    "username" => "Rimat@#",
    "password" => "Rimat@#"
);

$config["dist_upozila"] = array(
        "Dhaka"       => array("Dhamrai ", "Dohar ", "Keraniganj ", "Nawabganj ", "Savar "),
        "Faridpur"    => array("Faridpur Sodar ", "Boalmari ", "Alfadanga ", "Madhukhali ", "Bhanga ", "Nagarkanda ", "Charbhadrasan ", "Sodarpur ", "Shaltha "),
        "Gazipur"     => array("Gazipur Sodar-Joydebpur", "Kaliakior", "Kapasia", "Sripur", "Kaliganj", "Tongi"),
        "Gopalganj"   => array("Gopalganj Sodar ", "Kashiani ", "Kotalipara ", "Muksudpur ", "Tungipara "),
        "Jamalpur"    => array("Dewanganj ", "Baksiganj ", "Islampur ", "Jamalpur Sodar ", "Madarganj ", "Melandaha ", "Sarishabari ", "Narundi Police I.C"),
        "Kishoreganj" => array("Astagram ", "Bajitpur ", "Bhairab ", "Hossainpur ", "Itna ", "Karimganj ", "Katiadi ", "Kishoreganj Sodar ", "Kuliarchar ", "Mithamain ", "Nikli ", "Pakundia ", "Tarail "),
        "Madaripur"   => array("Madaripur Sodar", "Kalkini", "Rajoir", "Shibchar"),
        "Manikganj"   => array("Manikganj Sodar ", "Singair ", "Shibalaya ", "Saturia ", "Harirampur ", "Ghior ", "Daulatpur "),
        "Munshiganj"  => array("Lohajang ", "Sreenagar ", "Munshiganj Sodar ", "Sirajdikhan ", "Tongibari ", "Gazaria "),
        "Mymensingh"  => array("Bhaluka", "Trishal", "Tarakanda","Haluaghat", "Muktagacha", "Dhobaura", "Fulbaria", "Gaffargaon", "Gauripur", "Ishwarganj", "Mymensingh Sodar", "Nandail", "Fulpur"),
        "Narayanganj" => array("Araihazar ", "Sonargaon ", "Bandar", "Naryanganj Sodar ", "Rupganj ", "Siddirgonj "),
        "Narsingdi"   => array("Belabo ", "Monohardi ", "Narsingdi Sodar ", "Palash ", "Raipura , Narsingdi", "Shibpur "),
        "Netrokona"   => array("Kendua", "Atpara", "Barhatta", "Durgapur", "Kalmakanda", "Madan", "Mohanganj", "Netrakona-S", "Purbadhala", "Khaliajuri"),
        "Rajbari"     => array("Baliakandi ", "Goalandaghat ", "Pangsha ", "Kalukhali ", "Rajbari Sodar "),
        "Shariatpur"  => array("Shariatpur Sodar -Palong", "Damudya ", "Naria ", "Jajira ", "Bhedarganj ", "Gosairhat "),
        "Sherpur"     => array("Jhenaigati ", "Nakla ", "Nalitabari ", "Sherpur Sodar ", "Sreebardi "),
        "Tangail"     => array("Tangail Sodar ", "Sakhipur ", "Basail ", "Madhupur ", "Ghatail ", "Kalihati ", "Nagarpur ", "Mirzapur ", "Gopalpur ", "Delduar ", "Bhuapur ", "Dhanbari "),
        "Bogra"       => array("Adamdighi", "Bogra Sodar", "Sherpur", "Dhunat", "Dhupchanchia", "Gabtali", "Kahaloo", "Nandigram", "Sahajanpur", "Sariakandi", "Shibganj", "Sonatala"),
        "Joypurhat"   => array("Joypurhat S", "Akkelpur", "Kalai", "Khetlal", "Panchbibi"),
        "Naogaon"     => array("Naogaon Sodar ", "Mohadevpur ", "Manda ", "Niamatpur ", "Atrai ", "Raninagar ", "Patnitala ", "Dhamoirhat ", "Sapahar ", "Porsha ", "Badalgachhi "),
        "Natore"      => array("Natore Sodar ", "Baraigram ", "Bagatipara ", "Lalpur ", "Natore Sodar ", "Baraigram "),
        "Nawabganj"   => array("Bholahat ", "Gomastapur ", "Nachole ", "Nawabganj Sodar ", "Shibganj "),
        "Pabna"       => array("Atgharia ", "Bera ", "Bhangura ", "Chatmohar ", "Faridpur ", "Ishwardi ", "Pabna Sodar ", "Santhia ", "Sujanagar "),
        "Rajshahi"    => array("Bagha", "Bagmara", "Charghat", "Durgapur", "Godagari", "Mohanpur", "Paba", "Puthia", "Tanore"),
        "Sirajgonj"   => array("Sirajganj Sodar ", "Belkuchi ", "Chauhali ", "Kamarkhanda ", "Kazipur ", "Raiganj ", "Shahjadpur ", "Tarash ", "Ullahpara "),
        "Dinajpur"    => array("Birampur ", "Birganj", "Biral ", "Bochaganj ", "Chirirbandar ", "Phulbari ", "Ghoraghat ", "Hakimpur ", "Kaharole ", "Khansama ", "Dinajpur Sodar ", "Nawabganj", "Parbatipur "),
        "Gaibandha"   => array("Fulchhari", "Gaibandha Sodar", "Gobindaganj", "Palashbari", "Sadullapur", "Saghata", "Sundarganj"),
        "Kurigram"    => array("Kurigram Sodar", "Nageshwari", "Bhurungamari", "Phulbari", "Rajarhat", "Ulipur", "Chilmari", "Rowmari", "Char Rajibpur"),
        "Lalmonirhat" => array("Lalmanirhat Sodar", "Aditmari", "Kaliganj", "Hatibandha", "Patgram"),
        "Nilphamari"  => array("Nilphamari Sodar", "Saidpur", "Jaldhaka", "Kishoreganj", "Domar", "Dimla"),
        "Panchagarh"  => array("Panchagarh Sodar", "Debiganj", "Boda", "Atwari", "Tetulia"),
        "Rangpur"     => array("Badarganj", "Mithapukur", "Gangachara", "Kaunia", "Rangpur Sodar", "Pirgachha", "Pirganj", "Taraganj"),
        "Thakurgaon"  => array("Thakurgaon Sodar ", "Pirganj ", "Baliadangi ", "Haripur ", "Ranisankail "),
        "Barguna"     => array("Amtali ", "Bamna ", "Barguna Sodar ", "Betagi ", "Patharghata ", "Taltali "),
        "Barisal"     => array("Muladi ", "Babuganj ", "Agailjhara ", "Barisal Sodar ", "Bakerganj ", "Banaripara ", "Gaurnadi ", "Hizla ", "Mehendiganj ", "Wazirpur "),
        "Bhola"       => array("Bhola Sodar ", "Burhanuddin ", "Char Fasson ", "Daulatkhan ", "Lalmohan ", "Manpura ", "Tazumuddin "),
        "Jhalokati"   => array("Jhalokati Sodar ", "Kathalia ", "Nalchity ", "Rajapur "),
        "Patuakhali"  => array("Bauphal ", "Dashmina ", "Galachipa ", "Kalapara ", "Mirzaganj ", "Patuakhali Sodar ", "Dumki ", "Rangabali "),
        "Pirojpur"    => array("Bhandaria", "Kaukhali", "Mathbaria", "Nazirpur", "Nesarabad", "Pirojpur Sodar", "Zianagar"),
        "Bandarban"   => array("Bandarban Sodar", "Thanchi", "Lama", "Naikhongchhari", "Ali kadam", "Rowangchhari", "Ruma"),
        "Brahmanbaria"=> array("Brahmanbaria Sodar ", "Ashuganj ", "Nasirnagar ", "Nabinagar ", "Sarail ", "Shahbazpur Town", "Kasba ", "Akhaura ", "Bancharampur ", "Bijoynagar "),
        "Chandpur"    => array("Chandpur Sodar", "Faridganj", "Haimchar", "Haziganj", "Kachua", "Matlab Uttar", "Matlab Dakkhin", "Shahrasti"),
        "Chittagong"  => array("Anwara ", "Banshkhali ", "Boalkhali ", "Chandanaish ", "Fatikchhari ", "Hathazari ", "Lohagara ", "Mirsharai ", "Patiya ", "Rangunia ", "Raozan ", "Sandwip ", "Satkania ", "Sitakunda "),
        "Comilla"     => array("Barura ", "Brahmanpara ", "Burichong ", "Chandina ", "Chauddagram ", "Daudkandi ", "Debidwar ", "Homna ", "Comilla Sodar ", "Laksam ", "Monohorgonj ", "Meghna ", "Muradnagar ", "Nangalkot ", "Comilla Sodar South ", "Titas "),
        "Cox's Bazar" => array("Chakaria", "Cox's Bazar Sodar", "Kutubdia", "Maheshkhali", "Ramu", "Teknaf", "Ukhia", "Pekua"),
        "Feni"        => array("Feni Sodar", "Chagalnaiya", "Daganbhyan", "Parshuram", "Fhulgazi", "Sonagazi"),
        "Khagrachari" => array("Dighinala", "Khagrachhari", "Lakshmichhari", "Mahalchhari", "Manikchhari", "Matiranga", "Panchhari", "Ramgarh"),
        "Lakshmipur"  => array("Lakshmipur Sodar", "Raipur", "Ramganj", "Ramgati", "Komol Nagar"),
        "Noakhali"    => array("Noakhali Sodar", "Begumganj", "Chatkhil", "Companyganj", "Shenbag", "Hatia", "Kobirhat", "Sonaimuri", "Suborno Char"),
        "Rangamati"   => array("Rangamati Sodar", "Belaichhari", "Bagaichhari", "Barkal", "Juraichhari", "Rajasthali", "Kaptai", "Langadu", "Nannerchar", "Kaukhali"),
        "Habiganj"    => array("Ajmiriganj", "Baniachang", "Bahubal", "Chunarughat", "Habiganj Sodar", "Lakhai", "Madhabpur", "Nabiganj", "Shaistagonj Upazila"),
        "Maulvibazar" => array("Moulvibazar Sodar", "Barlekha", "Juri", "Kamalganj", "Kulaura", "Rajnagar", "Sreemangal"),
        "Sunamganj"   => array("Bishwamvarpur", "Chhatak", "Derai", "Dharampasha", "Dowarabazar", "Jagannathpur", "Jamalganj", "Sulla", "Sunamganj Sodar", "Shanthiganj", "Tahirpur"),
        "Sylhet"      => array("Sylhet Sodar", "Beanibazar", "Bishwanath", "Dakshin Surma Upazila", "Balaganj", "Companiganj", "Fenchuganj", "Golapganj", "Gowainghat", "Jaintiapur", "Kanaighat", "Zakiganj", "Nobigonj"),
        "Bagerhat"    => array("Bagerhat Sodar", "Chitalmari", "Fakirhat", "Kachua", "Mollahat", "Mongla", "Morrelganj", "Rampal", "Sarankhola"),
        "Chuadanga"   => array("Damurhuda", "Chuadanga-S", "Jibannagar", "Alamdanga"),
        "Jessore"     => array("Abhaynagar", "Keshabpur", "Bagherpara", "Jessore Sodar", "Chaugachha", "Manirampur", "Jhikargachha", "Sharsha"),
        "Jhenaidah"   => array("Jhenaidah Sodar", "Maheshpur", "Kaliganj", "Kotchandpur", "Shailkupa", "Harinakunda"),
        "Khulna"      => array("Terokhada", "Batiaghata", "Dacope", "Dumuria", "Dighalia", "Koyra", "Paikgachha", "Phultala", "Rupsa"),
        "Kushtia"     => array("Kushtia Sodar", "Kumarkhali", "Daulatpur", "Mirpur", "Bheramara", "Khoksa"),
        "Magura"      => array("Magura Sodar", "Mohammadpur", "Shalikha", "Sreepur"),
        "Meherpur"    => array("angni", "Mujib Nagar", "Meherpur-S"),
        "Narail"      => array("Narail-S", "Lohagara", "Kalia"),
        "Satkhira"    => array("Satkhira Sodar", "Assasuni", "Debhata", "Tala", "Kalaroa", "Kaliganj", "Shyamnagar")
);

//transaction type
$config['type'] = array(
 "Debit"    => "Withdraw",
 "CTB"      => "Cash to Bank",
 "BTC"      => "Bank To Cash",
 "Credit"   => "Payment",
 "bank_to_TT" => "Bank to T.T"
);
$config['status'] = array('available','not available');



//server configuration
 $config['configuration'] = array(
    'protocol'  => 'smtp',
    'smtp_host' => 'mail.nurelectronicsbd.com',
    'smtp_port' =>  26,
    'smtp_user' => 'support@nurelectronicsbd.com',
    'smtp_pass' => '}yn$qADF1KtO',
    'mailtype'  => 'html',
    'charset'   => 'utf-8'
);
$config['domain'] = array("nurelectronicsbd.com");