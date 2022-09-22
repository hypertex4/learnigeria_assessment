<?php include_once("inc/header.nav.php"); if (!isset($_SESSION['USER_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Assessments</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="dashboard"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Assessment</span></li>
            </ol>
            <span class="sidebar-right-toggle">&nbsp;</span>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <section class="card m-0">
                <header class="card-header">
                    <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle=""></a></div>
                    <h2 class="card-title">Student Results</h2>
                </header>
                <div class="card-body">
                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
                        <thead>
                        <tr>
                            <th>s/no</th>
                            <th>Ass.Name</th>
                            <th>Stud.Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Sch.Type</th>
                            <th>Sam.No</th>
                            <th>Ass.Date</th>
                            <th>StartTime</th>
                            <th>EndTime</th>
                            <th>H/Sch_ID</th>
                            <th>State</th>
                            <th>Literacy</th>
                            <th>Numeracy</th>
                            <th>Hausa</th>
                            <th>Igbo</th>
                            <th>Yoruba</th>
                            <th>EthnoMaths</th>
                            <th>Bonus</th>
                            <th>Curr.State</th>
                            <th>Curr.Lga</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = $client->get_all_client_assessments($_SESSION['USER_LOGIN']['user_id']);
                        if ($res->num_rows > 0) {$n=0;
                            while ($ass = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td data-title="sno"><?=++$n;?></td>
                                    <td data-title="Assessor Name"><?= $ass['user_name'];?></td>
                                    <td data-title="Student Name"><?= $ass['stud_name'];?></td>
                                    <td data-title="Age"><?= $ass['age'];?></td>
                                    <td data-title="Gender"><?= $ass['gender'];?></td>
                                    <td data-title="Grade"><?= $ass['grade'];?></td>
                                    <td data-title="Status"><?= $ass['enrol_status'];?></td>
                                    <td data-title="School Typ"><?= $ass['school_type'];?></td>
                                    <td data-title="Sample No"><?= $ass['sample_no'];?></td>
                                    <td data-title="Ass. Date"><?= date("d-m-Y", strtotime($ass['ass_created_on']));?></td>
                                    <td data-title="Start Time"><?= $ass['start_time'];?></td>
                                    <td data-title="End Time"><?= $ass['end_time'];?></td>
                                    <td data-title="House/Sch ID"><?= $ass['home_sch_id'];?></td>
                                    <td data-title="State"><?= $ass['state'];?></td>
                                    <td data-title="Literacy"><?= $ass['literacy'];?></td>
                                    <td data-title="Numeracy"><?= $ass['numeracy'];?></td>
                                    <td data-title="Hausa"><?= $ass['hausa'];?></td>
                                    <td data-title="Igbo"><?= $ass['igbo'];?></td>
                                    <td data-title="Yoruba"><?= $ass['yoruba'];?></td>
                                    <td data-title="EthnoMaths"><?= $ass['ethnomaths'];?></td>
                                    <td data-title="Bonus"><?= $ass['bonus'];?></td>
                                    <td data-title="Curr. State"><?= $ass['current_state'];?></td>
                                    <td data-title="Curr. Lga"><?= $ass['current_lga'];?></td>
                                </tr>
                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Assessment found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.nav.php"); ?>
<script src="js/examples/examples.datatables.tabletools.js"></script>
