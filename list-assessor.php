<?php include_once("inc/header.nav.php"); if (!isset($_SESSION['USER_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>List Assessors</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="dashboard"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>List Assessors</span></li>
                </ol>
                <span class="sidebar-right-toggle">&nbsp;</span>
            </div>
        </header>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">list assessors</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="add-assessor" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Add New Assessor</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-support">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Assessor ID</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $client->get_all_user_account($_SESSION['USER_LOGIN']['client_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td>#<?=++$n;?></td>
                                        <td><?= $row['user_name'];?></td>
                                        <td><?= $row['user_email'];?></td>
                                        <td><?= $row['user_id'];?></td>
                                        <td>
                                            <?=($row['user_active'] =='yes')?
                                                '<span class="badge badge-success">Active</span>':
                                                '<span class="badge badge-danger">In-Active</span>';?>
                                        </td>
                                        <td><?= date("d/m/Y h:i a",strtotime($row['usr_created_on']));?></td>
                                        <td class="actions">
                                            <a href="edit-assessor/<?= $row['user_id'];?>" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" data-u_id="<?= $row['user_id'];?>" class="on-default remove-row" id="assessorDeleteBtn">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                            <?php if ($row['user_active'] =='yes'){ ?>
                                                <button data-u_id="<?=$row['user_id'];?>" title="Deactivate assessor account" data-active="no" class="btn btn-xm btn-danger px-1 py-0" id="assessorStatusBtn">
                                                    Disable
                                                </button>
                                            <?php } else { ?>
                                                <button data-u_id="<?=$row['user_id'];?>" title="Activate assessor account" data-active="yes" class="btn btn-xm btn-success px-1 py-0" id="assessorStatusBtn">
                                                    Activate
                                                </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No assessor found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.nav.php"); ?>