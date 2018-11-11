<?php 
include("auth.php"); 
include("header.php"); 
include("restapi/request.php");
include("restapi/tmp_request.php");
$user_id = $_SESSION['UID'];

// initialize object
$request = new Request($db);
$tmp_request = new tmp_Request($db);
 
// query requests
$stmt = $request->count_free();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count_free = $row['count_free'];

$stmt = $request->count_in_work();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count_in_work = $row['count_in_work'];

$stmt = $request->count_in_help();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count_in_help = $row['count_in_help'];

$stmt = $tmp_request->count_tmp();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count_tmp = $row['count_tmp'];

$reqs = $tmp_request->read();

?>


    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">		
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Неназначенные заявки </h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $count_free; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="ni ni-bell-55"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <a href="free_requests.php"><span class="text-nowrap">Перейти</span></a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Заявки в процессе работы</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $count_in_work; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="ni ni-user-run"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <a href="work_requests.php"><span class="text-nowrap">Перейти</span></a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Заявки, требующие отклик</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $count_in_help; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="ni ni-chat-round"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <a href="help_requests.php"><span class="text-nowrap">Перейти</span></a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Заявки от посетителей</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $count_tmp; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <a href="tmp_requests.php"><span class="text-nowrap">Перейти</span></a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <!-- Table -->
      <!-- Dark table -->
      <div class="row mt-5">
        <div class="col">
          <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
              <h3 class="text-white mb-0">Заявки от посетителей</h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-dark table-flush">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Заявка</th> <!--№, дата, помещение, тип  работ-->
                    <th scope="col">Автор (vk_id)</th>
                    <th scope="col">Информация</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
				<?php while($row = $reqs->fetch(PDO::FETCH_ASSOC)) 
                { 
	              $req_id = $row['id'];
				  $req_create_date = $row['create_date'];
                  $req_creator_vkid = $row['creator_vk_id'];
				  $req_area_name = $row['area_name'];
				  $req_remark = $row['remark'];
				?>
				
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        
                        
                       
                        <div class="media-body">
                          <a href="http://vkapi.ibisolutions.ru/single_tmp_request.php?id=<?php echo $req_id;?>">
						  <span class="mb-0 text-sm"></span><?php echo "Номер: $req_id;</br>Создана: $req_create_date</br>Где: $req_area_name";?>
						  </a>
                        </div>
                      </div>
                    </th>
                    <td>
                      <?php echo $req_creator_vkid;?>
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                        <?php echo $req_remark;?>
                      </span>
                  </tr>  
                <?php } ?>				  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

<?php 
include("footer.php");
?>

