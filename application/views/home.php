<!--main-section-start-->
<section class="main-section paddind" id="Portfolio">
        <div class="container">
            <h2>Products</h2>
            <h6>Here is our products.</h6>
          <div class="portfolioFilter">  
            <ul class="Portfolio-nav wow fadeIn delay-02s">
                <li><a href="#" data-filter="*" class="current" >All</a></li>
                <?php foreach ($product_cat as $value) { ?>
                <li><a href="#" data-filter=".<?php echo $value->category; ?>" ><?php echo filter($value->category); ?></a></li>
                <?php } ?>
            </ul>
           </div> 
            
        </div>
        <div class="portfolioContainer wow fadeInUp delay-04s">
            <?php foreach ($front_product as $value) { ?>
            <div class=" Portfolio-box <?php echo $value->category ?>">
                <a href="#"><img src="<?php echo site_url($value->image); ?>"></a>   
                <!-- <h3>Tiles One</h3> -->               
            </div>
            <?php } ?>
        </div>
</section>
<!--main-section-end-->







<style>
    #price table{background: #fff;}
</style>
<!-- price list -->
    <section class="main-section" id="price" style="background:#fafafa;">
        <div class="container">
            <h2>Price List</h2>
            <h6>Price List of our products.</h6>
            <div class="row">
                <div class="col-lg-4 col-sm-4 wow fadeInLeft delay-05s">
                    <?php if ($cementInfo != null) { ?>
                    <table class="table table-bordered">
                        <tr>
                            <th class="text-center" colspan="3">Cement</th>
                        </tr>

                        <tr>
                            <th>SL</th>
                            <th>Brand Name</th>
                            <th>Price BDT</th>
                        </tr>

                        <?php  foreach ($cementInfo as $key => $row) { ?>
                        <tr>
                            <td><?php echo $key +1; ?></td>
                            <td><?php echo $row->subcategory; ?></td>
                            <td><?php echo $row->sale_price; ?></td>
                        </tr>   

                        <?php } ?>
                    </table>
                    <?php } ?>
                </div>  

                <div class="col-lg-4 col-sm-4 wow fadeInLeft delay-05s">
                    <?php if ($rodInfo != null) { ?>
                    <table class="table table-bordered">
                        <tr>
                            <th class="text-center" colspan="3">Steel</th>
                        </tr>

                        <tr>
                            <th>SL</th>
                            <th>Brand Name</th>
                            <th>Price BDT</th>
                        </tr>

                        <?php  foreach ($rodInfo as $key => $row) { ?>
                        <tr>
                            <td><?php echo $key +1; ?></td>
                            <td><?php echo $row->subcategory; ?></td>
                            <td><?php echo $row->sale_price; ?></td>
                        </tr>   

                        <?php } ?>
                    </table>
                    <?php } ?>
                </div>

                <div class="col-lg-4 col-sm-4 wow fadeInLeft delay-05s">
                    <?php if ($gasInfo != null) { ?>
                    <table class="table table-bordered">
                        <tr>
                            <th class="text-center" colspan="3">GAS</th>
                        </tr>

                        <tr>
                            <th>SL</th>
                            <th>Brand Name</th>
                            <th>Price BDT</th>
                        </tr>

                        <?php  foreach ($gasInfo as $key => $row) { ?>
                        <tr>
                            <td><?php echo $key +1; ?></td>
                            <td><?php echo $row->subcategory; ?></td>
                            <td><?php echo $row->sale_price; ?></td>
                        </tr>   

                        <?php } ?>
                    </table>
                    <?php } ?>
                </div>

            </div>
        </div>
    </section>
<!-- price list -->








<style>
    #sister img{border: 1px solid #ddd; background: #fff; margin-bottom: 25px;}
</style>
<!-- Siter Concern -->
    <section class="main-section" id="sister">
        <div class="container">
            <h2>Sister Concern</h2>
            <h6>All of our Sister Concern.</h6>
            
            <div class="row">
                <div class="col-lg-12 col-sm-12 wow fadeInLeft delay-05s">
                    <?php 
                    if ($sisterConcern != null) {
                    foreach ($sisterConcern as $key => $row) {
                    ?>  
                    <div class="col-md-3">
                        <img class="img-responsive" src="<?php echo site_url($row->image); ?>" />
                    </div>
                    <?php }} ?>
                </div>
            </div>
        </div>
    </section>
<!-- Siter Concern -->








<!--main-section-start-->
    <section class="main-section" id="csr" style="background:#fafafa;">
        <div class="container">
            <h2>Corporate Social Responsibility</h2>
            <h6>Corporate Social Responsibility.</h6>
            <div class="row">
                <div class="col-lg-6 col-sm-6 wow fadeInLeft delay-05s">
                    <div class="service-list">
                        <div class="service-list-col1">
                            <i class="fa-gear"></i>
                        </div>
                        <div class="service-list-col2">
                            <h3>Social Responsibility One</h3>
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                    </div>
                    <div class="service-list">
                        <div class="service-list-col1">
                            <i class="fa-gear"></i>
                        </div>
                        <div class="service-list-col2">
                            <h3>Social Responsibility Two</h3>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                    </div>
                    <div class="service-list">
                        <div class="service-list-col1">
                            <i class="fa-gear"></i>
                        </div>
                        <div class="service-list-col2">
                            <h3>Social Responsibility Three</h3>
                            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
                        </div>
                    </div>
                    <div class="service-list">
                        <div class="service-list-col1">
                            <i class="fa-gear"></i>
                        </div>
                        <div class="service-list-col2">
                            <h3>Social Responsibility Four</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
                <figure class="col-lg-6 col-sm-6  text-right wow fadeInUp delay-02s">
                    <img style="max-width: 500px;" class="img-responsive img-thumbnail" src="<?php echo site_url('public/images/we.jpg'); ?>">
                </figure>
            
            </div>
        </div>
    </section>
<!--main-section-end-->








<!--main-section team-start-->
    <section class="main-section team" id="directors">
      <div class="container">
            <h2>Board Of Directors</h2>
            <h6>Our Honourable Board Of Directors.</h6>
            <div class="team-leader-block clearfix">
                <div class="team-leader-box">
                    <div class="team-leader wow fadeInDown delay-03s"> 
                        <div class="team-leader-shadow"><a href="#"></a></div>
                        <img src="<?php echo site_url('public/images/team-leader-pic2.jpg'); ?>" alt="">
                    </div>
                    <h3 class="wow fadeInDown delay-03s">Walter White</h3>
                    <span class="wow fadeInDown delay-03s">Founder</span>
                    <p class="wow fadeInDown delay-03s">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin consequat sollicitudin cursus. Dolor sit amet, consectetur adipiscing elit proin consequat.</p>
                </div>
                <div class="team-leader-box">
                    <div class="team-leader  wow fadeInDown delay-06s"> 
                        <div class="team-leader-shadow"><a href="#"></a></div>
                        <img src="<?php echo site_url('public/images/team-leader-pic2.jpg'); ?>" alt="">
                    </div>
                    <h3 class="wow fadeInDown delay-06s">Jesse Pinkman</h3>
                    <span class="wow fadeInDown delay-06s">Founder</span>
                    <p class="wow fadeInDown delay-06s">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin consequat sollicitudin cursus. Dolor sit amet, consectetur adipiscing elit proin consequat.</p>
                </div>
                <div class="team-leader-box">
                    <div class="team-leader wow fadeInDown delay-09s"> 
                        <div class="team-leader-shadow"><a href="#"></a></div>
                        <img src="<?php echo site_url('public/images/team-leader-pic2.jpg'); ?>" alt="">
                    </div>
                    <h3 class="wow fadeInDown delay-09s">Skyler white</h3>
                    <span class="wow fadeInDown delay-09s">Founder</span>
                    <p class="wow fadeInDown delay-09s">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin consequat sollicitudin cursus. Dolor sit amet, consectetur adipiscing elit proin consequat.</p>
                </div>
            </div>
        </div>
    </section>
<!--main-section team-end-->








<!--main-section alabaster-start-->

  <section class="main-section alabaster" id="gallery" style="background:#fafafa;">
    <div class="container">
        <h2>Gallery</h2>
        <h6>Our Photos</h6>
        <div class="row">
            <div class="col-lg-12 col-sm-12 featured-work">
                <!-- <h2>Gallery</h2> -->
                 <div class="row">
                <?php foreach ($gallery as $value) { ?>
                   <div class="col-md-3">
                     <a class="example-image-link" href="<?php echo site_url($value->gallery_path); ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
					 <img style="width: 100%;height: auto;height: 180px; overflow-x: hidden; margin-bottom: 20px;" class="example-image img-thumbnail" src="<?php echo site_url($value->gallery_path); ?>" />
					 </a>
                   </div>
                <?php } ?>
                 </div>
              </div>
          </div>
    </div>
  </section>
<!--main-section alabaster-end-->








<!--main-section alabaster-start-->
    <section class="main-section alabaster" id="career" style="background:#fff;">
        <div class="container">
            <div class="row">
                <figure class="col-lg-5 col-sm-4 wow fadeInLeft">
                    <img src="<?php echo site_url('public/images/career.jpg'); ?>" class="img-responsive img-thumbnail">
                </figure>
                <div class="col-lg-7 col-sm-8 featured-work">
                    <h2>Career in the Company</h2>
                    <P class="padding-b">Proin iaculis purus consequat sem cure digni ssim. Donec porttitora entum suscipit aenean rhoncus posuere odio in tincidunt. Proin iaculis purus consequat sem cure digni ssim. Donec porttitora entum suscipit.</P>
                    <div class="featured-box">
                        <div class="featured-box-col1 wow fadeInRight delay-02s">
                            <i class="fa-gear"></i>
                        </div>  
                        <div class="featured-box-col2 wow fadeInRight delay-02s">
                            <h3>magic of theme career</h3>
                            <p>Proin iaculis purus consequat sem cure digni ssim. Donec porttitora entum suscipit aenean rhoncus posuere odio in tincidunt. </p>
                        </div>    
                    </div>
                    <div class="featured-box">
                        <div class="featured-box-col1 wow fadeInRight delay-04s">
                            <i class="fa-gear"></i>
                        </div>  
                        <div class="featured-box-col2 wow fadeInRight delay-04s">
                            <h3>magic of theme career two</h3>
                            <p>Proin iaculis purus consequat sem cure digni ssim. Donec porttitora entum suscipit aenean rhoncus posuere odio in tincidunt. </p>
                        </div>    
                    </div>
                    <a class="Learn-More" href="#">Learn More</a>
                </div>
            </div>
        </div>
    </section>
<!--main-section alabaster-end-->






<section class="business-talking"><!--business-talking-start-->
    <div class="container">
        <h2>Let’s Talk Business.</h2>
    </div>
</section><!--business-talking-end-->
<div class="container">

<section class="main-section contact" id="contact">
        <div class="row">
            <div class="col-lg-6 col-sm-7 wow fadeInLeft">
                <br><br><br>
                <div class="contact-info-box address clearfix">
                    <h3><i class=" icon-map-marker"></i>Address:</h3>
                    <span>54 Bora Bazar, Mymensingh, <br>Mymensingh 2200, Bangladesh.</span>
                </div>
                <div class="contact-info-box phone clearfix">
                    <h3><i class="fa-phone"></i>Phone:</h3>
                    <span>+880 1762-688999</span>
                </div>
                <!-- <div class="contact-info-box email clearfix">
                    <h3><i class="fa-pencil"></i>email:</h3>
                    <span>hello@knightstudios.com</span>
                </div> -->
                <!-- <div class="contact-info-box hours clearfix">
                    <h3><i class="fa-clock-o"></i>Hours:</h3>
                    <span><strong>Monday - Thursday:</strong> 10am - 6pm<br><strong>Friday:</strong> People work on Fridays now?<br><strong>Saturday - Sunday:</strong> Best not to ask.</span>
                </div> -->
                <ul class="social-link">
                    <li class="twitter"><a href="#"><i class="fa-twitter"></i></a></li>
                    <li class="facebook"><a href="#"><i class="fa-facebook"></i></a></li>
                    <li class="pinterest"><a href="#"><i class="fa-pinterest"></i></a></li>
                    <li class="gplus"><a href="#"><i class="fa-google-plus"></i></a></li>
                    <li class="dribbble"><a href="#"><i class="fa-dribbble"></i></a></li>
                </ul>
            </div>
            <div class="col-lg-6 col-sm-5 wow fadeInUp delay-05s">
               <?php echo $this->session->flashdata("confirmation"); ?>
                <div class="form"> 
                 <?php $attr = array("class" => "contactForm"); ?> 
                  <?php echo form_open("home/visitor_comments",$attr);?>     
                      <div class="form-group">
                            <input type="text" name="name" class="form-control input-text"  placeholder="Your Name" required />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control input-text" name="email"  placeholder="Your Email" required />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-text" name="subject"  placeholder="Subject" required />
                            <div class="validation"></div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control input-text text-area" name="message" rows="5"  placeholder="Message" required ></textarea>
                            <div class="validation"></div>
                        </div>
                        
                        <div class="text-center">
                           <input type="submit" class="input-btn" value="Send Message">                           
                        </div>
                    <?php form_close(); ?>
                </div>  
            </div>
        </div>
</section>
</div>


