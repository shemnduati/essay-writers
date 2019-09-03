<ul class="sidebar-menu">
            <li <?php if($page=='dashboard'){ ?> class="active"<?php }  ?>>
              <a href="index.php?page=dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            
            <li <?php if(($page=='specialities' || $page=='viewsubtitles')){ ?> class="active" <?php } ?>>
              <a href="index.php?page=specialities">
                <i class="fa fa-circle-o text-aqua"></i> <span>Specialities</span>
              </a>
            </li>
            
            <li <?php if(($page=='questions')){ ?> class="active" <?php } ?>>
              <a href="index.php?page=questions">
                <i class="fa fa-question text-red"></i> <span>Questions</span>
              </a>
            </li>
            
            <li <?php if(($page=='orders' || $page=='vieworder')){ ?> class="active" <?php } ?>>
              <a href="#">
                <i class="fa fa-files-o"></i> <span>Orders</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(($subpage=='orders-site-a')){ ?> class="active" <?php } ?>><a href="index.php?page=orders&subpage=orders-site-a">Site A Orders</a></li>
                <li <?php if(($subpage=='orders-site-b')){ ?> class="active" <?php } ?>><a href="index.php?page=orders&subpage=orders-site-b">Site B Orders</a></li>
                <li <?php if(($subpage=='orders-site-c')){ ?> class="active" <?php } ?>><a href="index.php?page=orders&subpage=orders-site-c">Site C Orders</a></li>
              </ul>
            </li>
            
            <li <?php if(($page=='earnings')){ ?> class="active" <?php } ?>>
              <a href="index.php?page=earnings">
                <i class="fa fa-money"></i> <span>Earnings</span>
              </a>
            </li>
            
            <li <?php if(($page=='clients')){ ?> class="active" <?php } ?>>
              <a href="#">
                <i class="fa fa-circle-o text-yellow"></i> <span>Clients</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(($subpage=='clients-site-a')){ ?> class="active" <?php } ?>><a href="index.php?page=clients&subpage=clients-site-a">Site A Clients</a></li>
                <li <?php if(($subpage=='clients-site-b')){ ?> class="active" <?php } ?>><a href="index.php?page=clients&subpage=clients-site-b">Site B Clients</a></li>
                <li <?php if(($subpage=='clients-site-c')){ ?> class="active" <?php } ?>><a href="index.php?page=clients&subpage=clients-site-c">Site C Clients</a></li>
              </ul>
            </li>
            
            <li <?php if(($page=='writers' || $page=='viewtitles')){ ?> class="active" <?php } ?>>
              <a href="index.php?page=writers">
                <i class="fa fa-circle-o text-aqua"></i> <span>Writers</span>
              </a>
            </li>
            
            <li <?php if(($page=='email')){ ?> class="active" <?php } ?>>
              <a href="index.php?page=email">
                <i class="fa fa-envelope"></i> <span>Messaging</span>
              </a>
            </li>
            
            <li class="<?php if(($page=='settings')){ ?>active<?php } ?> treeview">
              <a href="#">
                <i class="fa fa-cog"></i>
                <span>Settings</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(($subpage=='users')){ ?> class="active" <?php } ?>><a href="index.php?page=settings&subpage=users"><i class="fa fa-group"></i> Admins</a></li>
                <li <?php if(($subpage=='payment_setting')){ ?> class="active" <?php } ?>><a href="index.php?page=settings&subpage=payment_setting"><i class="fa fa-envelope"></i> Update Paypal Email</a></li>
                <li <?php if(($subpage=='payment_threshold')){ ?> class="active" <?php } ?>><a href="index.php?page=settings&subpage=payment_threshold"><i class="fa fa-money"></i> Writers Payments Threshold</a></li>
                <li <?php if(($subpage=='default_percentage')){ ?> class="active" <?php } ?>><a href="index.php?page=settings&subpage=default_percentage"><i class="fa fa-asterisk "></i> Order Default Percentages</a></li>
              </ul>
            </li>
<li <?php if(($page=='content')){ ?> class="active" <?php } ?>>
              <a href="#">
                <i class="fa fa-circle-o text-yellow"></i> <span>Content</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              	  <div>
			<a href="#"><span onclick="openNav()"><li class="dropdown"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Writers</li></span></a>
			<a href="#"><span onclick="openNav2()"><li class="dropdown"><i class="fa fa-users"></i> &nbsp;&nbsp;Clients</li></span></a>
			<li></li>
				
		   </div>
		   <div id="mySidenav" class="sidenav" style="margin-top:10%;size:12;">
			  <font style="color:rgb(255,201,14);size:9;"><b>Content Menu for writers</b></font><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			  <li <?php if(($subpage=='home')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=home">Home</a></li>
                          <li <?php if(($subpage=='about_us')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=about_us">About us</a></li>
                          <li <?php if(($subpage=='contact_us')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=contact_us">Contact us</a></li>
                          <li <?php if(($subpage=='our_services')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=our_services">Our services</a></li>
                          <li <?php if(($subpage=='pricing')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=pricing">Pricing</a></li>
                          <li <?php if(($subpage=='our_writers')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=our_writers">Our writers</a></li>
                          <li <?php if(($subpage=='guarantees')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=guarantees">Guarantees</a></li>
                          <li <?php if(($subpage=='faq')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=faq">FAQs</a></li>
                          <li <?php if(($subpage=='testimonials')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=testimonials">Testimonials</a></li>
                          <li <?php if(($subpage=='samples')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=samples">Samples</a></li>
			  
			  
			</div>
			
			
			<div id="mySidenav2" class="sidenav" style="margin-top:10%;size:12;">
			  <font style="color:rgb(255,201,14);size:9;"><b>Content Menu for clients</b></font><a href="javascript:void(0)" class="closebtn" onclick="closeNavc()">&times;</a>
						<li <?php if(($subpage=='home2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=home2">Home</a></li>
                          <li <?php if(($subpage=='about_us2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=about_us2">About us</a></li>
                          <li <?php if(($subpage=='contact_us2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=contact_us2">Contact us</a></li>
                          <li <?php if(($subpage=='our_services2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=our_services2">Our services</a></li>
                          <li <?php if(($subpage=='pricing2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=pricing2">Pricing</a></li>
                          <li <?php if(($subpage=='our_writers2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=our_writers2">Our writers</a></li>
                          <li <?php if(($subpage=='guarantees2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=guarantees2">Guarantees</a></li>
                          <li <?php if(($subpage=='faq2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=faq2">FAQs</a></li>
                          <li <?php if(($subpage=='testimonials2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=testimonials2">Testimonials</a></li>
                          <li <?php if(($subpage=='samples2')){ ?> class="active" <?php } ?>><a href="index.php?page=content&subpage=samples2">Samples</a></li>
			  
			  
			</div>
		   
		   
		   
		   
				


              </ul>
            </li>
            
          </ul>
          
              		<script type="text/javascript">
		
				function openNav() {
  				  document.getElementById("mySidenav").style.width = "200px";
				}
				
				function openNav2(){
				  document.getElementById("mySidenav2").style.width = "200px";
				  }


				function closeNav() {
  			  document.getElementById("mySidenav").style.width = "0";
				}
				function closeNavc(){
				document.getElementById("mySidenav2").style.width="0";
				}
			</script>