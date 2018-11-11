<?php 
include("auth.php"); 
include("header.php"); 
include("restapi/request.php");
include("restapi/tmp_request.php");
$user_id = $_SESSION['UID'];
$search_data = $_SESSION['search_data'];

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


$find_users = $db->query("SELECT u.*, up.post as up_post, uc.name as u_category, a.name as area_name
                        FROM users u,
                             user_posts up,
                             user_categories uc,
                             areas a
                       WHERE u.post = up.id
                         AND u.category = uc.id
                         AND u.area = a.id
                         AND (u.name like '%$search_data%'
                          OR up.post like '%$search_data%'
                          OR u.lastname like '%$search_data%')");

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
              <h3 class="text-white mb-0">Найденные пользователи</h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-dark table-flush">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">ФИО</th> 
                    <th scope="col">Должность</th>
                    <th scope="col">Категория</th>
					<th scope="col">Контакты</th>
					<th scope="col">Кабинет</th>
                  </tr>
                </thead>
                <tbody>
				<?php while($row = $find_users->fetch(PDO::FETCH_ASSOC)) 
                { 
	              $id = $row['id'];
				  $name = $row['name'];
				  $lastname = $row['lastname'];
				  $self_phone = $row['self_phone'];
                  $work_phone = $row['work_phone'];
				  $email = $row['email'];
				  $up_post = $row['up_post'];
				  $u_category = $row['u_category'];
				  $area_name = $row['area_name'];
				?>
				
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        
                        
                       
                        <div class="media-body">
                          
						  <span class="mb-0 text-sm"></span><?php echo "$name</br>$lastname";?>
						
                        </div>
                      </div>
                    </th>
                    <td>
                      <?php echo $up_post;?>
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                        <?php echo $u_category;?>
                      </span>
					</td>
					 <td>
                      <span class="badge badge-dot mr-4">
                        <?php echo "Моб. тел. $self_phone;</br>Раб. тел. $work_phone</br>Email $email";?>
                      </span>
					</td>
					 <td>
                      <span class="badge badge-dot mr-4">
                        <?php echo $area_name;?>
                      </span>
					</td>
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

