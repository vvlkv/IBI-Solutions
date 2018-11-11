<?php 
include("auth.php"); 
include("header.php"); 
include("restapi/tmp_request.php");
$user_id = $_SESSION['UID'];
$request_id = isset($_GET['id']) ? $_GET['id'] : die();

$u_cats = $db->query("SELECT u.category 
                        FROM users u
                       WHERE u.id = '$user_id'
                     ");  
$access = $u_cats->fetch(PDO::FETCH_ASSOC);
$u_cat = $access['category'];


$requests = $db->query("SELECT tr.*, a.name as area_name
                          FROM  tmp_requests tr,
					              areas a
                         WHERE coalesce(tr.location, '-1') = a.id
				           AND tr.id = $request_id ");  
						   

				 
while($row = $requests->fetch(PDO::FETCH_ASSOC)) 
{ 
	$req_id = $row['id'];
	$req_remark = $row['remark'];
	$req_create_date = $row['create_date'];
	$area_name = $row['area_name'];	
	$req_creator_vkid = $row['creator_vk_id'];
    $image = $row['photo_url'];
}
?>
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">		
        <div class="header-body">
          <!-- Card stats -->
          <div class="row"> 
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="card-body pt-0 pt-md-4">
              <div class="text-center">
                <h3>
                  Дата создания:<span class="font-weight-light"><?php echo " $req_create_date"; ?></span>
                </h3>           
				<h3>
                  Создатель (vk_id):<span class="font-weight-light"><?php echo " $req_creator_vkid"; ?></span>
                </h3>
 
                <div>
                  <i class="ni education_hat mr-2"></i><?php echo "Где: $area_name"; ?> 
                </div>
                <hr class="my-4" />
                <p><?php echo $req_remark; ?> </p>
				<hr class="my-4" />
              </div>
            </div>
				

			<?php if (($u_cat == "ADM") || ($u_cat == "MDR")) { ?>
			  
			<div class="card-header text-center border-0 ">
              
                <form action="delete-tmp.php" method="post">

                  <div class="text-center">
				    <input type="hidden" name="tmp_id" value="<?php echo "$request_id"; ?>">
					<button id="<?php echo $request_id;?>"class="btn btn-sm btn-primary btn-del-tmp">Удалить</button>
                  </div>

              </form>

            </div>
			<?php } ?>
          </div>
        </div>
		<?php if (($u_cat == "ADM") || ($u_cat == "MDR")) { ?>
        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Перевести в заявку</h3>
                </div>
                <div class="col-4 text-right">
                  <button id="<?php echo $request_id;?>" class="btn btn-sm btn-primary btn-create-request">Отправить</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form>
                
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Справочная информация</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-area">Место</label>
                        <select id="input-area" name='area'>
								<?php  $areas = $db->query("SELECT id, concat(id, ' - ', name) as a_name FROM areas"); 
								 while($area = $areas->fetch(PDO::FETCH_ASSOC)) 
									{ 
										$name = $area['a_name']; 
										$id = $area['id'];
										echo "<option value=\"$id\">$name</option>";
									} 
								?>
					    </select>
                      </div>
                    </div>
				    <div class="col-md-2"></div>
					<div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-job-type">Вид работ/событий</label>
                        <select id="input-job-type" name='job-type'>
								<?php  $job_types = $db->query("SELECT id, name FROM job_types"); 
								 while($job = $job_types->fetch(PDO::FETCH_ASSOC)) 
									{ 
										$name = $job['name']; 
										$id = $job['id'];
										echo "<option value=\"$id\">$name</option>";
									} 
								?>
					    </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-cat">Категория заявки</label></br>
                        <select id="input-cat" name='cat'>
								<?php  $req_cats = $db->query("SELECT id, name FROM request_categories"); 
								 while($cat = $req_cats->fetch(PDO::FETCH_ASSOC)) 
									{ 
										$name = $cat['name']; 
										$id = $cat['id'];
										echo "<option value=\"$id\">$name</option>";
									} 
								?>
					    </select>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Description -->
                <h6 class="heading-small text-muted mb-4">Описание заявки/объявления</h6>
                <div class="pl-lg-4">
                  <div class="form-group">
                    <textarea rows="11" id="input-remark" class="form-control form-control-alternative" placeholder="Комментарий">Введите описание заявки/объявления</textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
		<?php } ?>
      </div>  
<?php	
include("footer.php");
?>