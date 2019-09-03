<div class="user-panel">
            <div class="pull-left image">
            <?php
				if ($count_pic > 0) {
					?>
					<img src="<?php echo $ploc; ?>" class="img-circle" alt="User Image" />
					<?php
				} else {
					?>
					<img src="dist/img/user.jpg" class="img-circle" alt="User Image" />   
					<?php
				}
				echo "$name";
			?> 
            </div>
            <div class="pull-left info">
              <p><?php echo "$name"; ?></p>
            </div>
          </div>