<?php include_once("inc/header.nav.php"); if (!isset($_SESSION['USER_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Default Layout</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="dashboard"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Dashboard</span></li>
            </ol>
            <span class="sidebar-right-toggle">&nbsp;</span>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <div class="row mb-3">
                <div class="col-xl-6">
                    <section class="card card-featured-left card-featured-primary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-primary">
                                        <i class="fas fa-life-ring"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Assessment</h4>
                                        <div class="info">
                                            <strong class="amount">
                                                <?=$client->count_total_assessment($_SESSION['USER_LOGIN']['user_id']);?>
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="javascript:void">(Assessor Assessment)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-6">
                    <section class="card card-featured-left card-featured-tertiary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-tertiary">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Client Total Student</h4>
                                        <div class="info">
                                            <strong class="amount">
                                                <?=$client->count_total_client_assessment($_SESSION['USER_LOGIN']['client_id']);?>
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="javascript:void">(Total Student Accessed)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-4">
        <div class="col-lg-6">
            <section class="card">
                <header class="card-header">
                    <h2 class="card-title">Gender Chart</h2>
                    <p class="card-subtitle">Client sex assessment bar chart</p>
                </header>
                <div class="card-body">
                    <div class="chart chart-md" id="flotBars"></div>
                    <script type="text/javascript">
                        var flotBarsData = [
                            ["Male", <?=$client->count_total_gender_student($_SESSION['USER_LOGIN']['client_id'],"Male");?>],
                            ["Female", <?=$client->count_total_gender_student($_SESSION['USER_LOGIN']['client_id'],"Female");?>]
                        ];
                    </script>
                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="card">
                <header class="card-header">
                    <h2 class="card-title">School Type Chart</h2>
                    <p class="card-subtitle">Client school type pie chart</p>
                </header>
                <div class="card-body">
                    <div class="chart chart-md" id="morrisDonut"></div>
                    <script type="text/javascript">
                        var morrisDonutData = [{
                            label: "Public",
                            value: <?=$client->count_total_school_type_student($_SESSION['USER_LOGIN']['client_id'],"Public");?>
                        }, {
                            label: "Private",
                            value: <?=$client->count_total_school_type_student($_SESSION['USER_LOGIN']['client_id'],"Private");?>
                        }, {
                            label: "Others",
                            value: <?=$client->count_total_school_type_student($_SESSION['USER_LOGIN']['client_id'],"Null");?>
                        }];
                    </script>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.nav.php"); ?>