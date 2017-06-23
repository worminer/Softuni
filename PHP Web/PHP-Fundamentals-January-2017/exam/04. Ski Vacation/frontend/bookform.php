<main class="container">
    <section class="row">
        <form class="form-horizontal" method="post">
            <div class="wall">
            </div>
            <fieldset class="well">
                <legend>Personal Information</legend>
                <div class="form-group col-md-6">
                    <label for="first_name" class="col-lg-4 control-label">First Name * :</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?= (isset($_POST['first_name'])) ? $_POST['first_name'] : "" ?>" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name" class="col-lg-4 control-label">Last Name * :</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="last_name" id="last_name" value="<?= (isset($_POST['last_name'])) ? $_POST['last_name'] : "" ?>" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="phone" class="col-lg-4 control-label">Phone Number * :</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="phone" id="phone" value="<?= (isset($_POST['phone'])) ? $_POST['phone'] : "" ?>" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="email" class="col-lg-4 control-label">Email</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="email" id="email" value="<?= (isset($_POST['email'])) ? $_POST['email'] : "" ?>" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="conf_email" class="col-lg-4 control-label">Confirm Email</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="conf_email" id="conf_email" value="<?= (isset($_POST['conf_email'])) ? $_POST['conf_email'] : "" ?>" required>
                    </div>
                </div>
            </fieldset>
            <fieldset class="well">
                <legend>Rooms Type or something ??!?</legend>
                <div class="form-group col-md-6">
                    <label for="select" class="col-lg-4 control-label">Type of accommidation: </label>
                    <div class="col-lg-8">
                        <select class="form-control" id="select" name="accommodationType">
                            <?php
                            if (isset($data["accommodationType"])) {

                                foreach ($data["accommodationType"] as $place_type){
                                    echo "<option value='". $place_type["id"]."'";
                                    ((isset($_POST['accommodationType']))&&($_POST['accommodationType'] == 1 )) ? 'selected' : '';
                                    echo " >".$place_type["name"]."</option>".PHP_EOL;
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="child_num" class="col-lg-4 control-label">Number of Children * :</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="child_num" id="child_num" value="<?= (isset($_POST['child_num'])) ? $_POST['child_num'] : "" ?>" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="adults_num" class="col-lg-4 control-label">Number of Adults * :</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="adults_num" id="adults_num" value="<?= (isset($_POST['adults_num'])) ? $_POST['adults_num'] : "" ?>" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="rooms" class="col-lg-4 control-label">Rooms</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="rooms" id="rooms" value="<?= (isset($_POST['rooms'])) ? $_POST['rooms'] : "" ?>">
                    </div>
                </div>
            </fieldset>
            <fieldset class="well">
                <legend>Booking date</legend>
                <div class="form-group col-md-6">
                    <label for="check_in" class="col-lg-4 control-label">Check-in Date*</label>
                    <div class="col-lg-8">
                        <input type="date" class="form-control" name="check_in" id="check_in" value="<?= (isset($_POST['check_in'])) ? $_POST['check_in'] : "" ?>" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="check_out" class="col-lg-4 control-label">Check-out Date*</label>
                    <div class="col-lg-8">
                        <input type="date" class="form-control" name="check_out" id="check_out" value="<?= (isset($_POST['check_out'])) ? $_POST['check_out'] : "" ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="lift" <?= ((isset($_POST['lift']))&&($_POST['lift'] !== null )) ? "checked" : "" ?> > Lift Pass
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="ski" <?= ((isset($_POST['ski']))&&($_POST['ski'] !== null )) ? "checked" : "" ?> > Ski instructor
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <input type="submit" name="book" class="btn btn-primary" value="Submit Reservation">
            <a href="" class="btn btn-primary pull-right">Show Reservations</a>
        </form>

    </section>
</main>2