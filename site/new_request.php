<?php 
include("auth.php"); 
include("header.php"); 
$user_id = $_SESSION['UID'];

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
      <!--<div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="../assets/img/theme/team-4-800x800.jpg" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
              <div class="d-flex justify-content-between">
                <a href="#" class="btn btn-sm btn-info mr-4">Connect</a>
                <a href="#" class="btn btn-sm btn-default float-right">Message</a>
              </div>
            </div>
            <div class="card-body pt-0 pt-md-4">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                    <div>
                      <span class="heading">22</span>
                      <span class="description">Friends</span>
                    </div>
                    <div>
                      <span class="heading">10</span>
                      <span class="description">Photos</span>
                    </div>
                    <div>
                      <span class="heading">89</span>
                      <span class="description">Comments</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <h3>
                  Jessica Jones<span class="font-weight-light">, 27</span>
                </h3>
                <div class="h5 font-weight-300">
                  <i class="ni location_pin mr-2"></i>Bucharest, Romania
                </div>
                <div class="h5 mt-4">
                  <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
                </div>
                <div>
                  <i class="ni education_hat mr-2"></i>University of Computer Science
                </div>
                <hr class="my-4" />
                <p>Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music.</p>
                <a href="#">Show more</a>
              </div>
            </div>
          </div>
        </div> -->
        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Новая заявка/объявление</h3>
                </div>
                <div class="col-4 text-right">
                  <button class="btn btn-sm btn-primary btn-create-request">Создать</button>
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
      </div>
<?php	
include("footer.php");
?>