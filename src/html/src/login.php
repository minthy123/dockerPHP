<?php
    include_once ("/var/www/html/src/service/UserService.php");
    $userService = new UserService();

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $keyFromDB = UserService::createKey($_POST['username'], $_POST['password']);
        if ($userService->checkSessionKey($keyFromDB)) {
            $_SESSION['key'] = $keyFromDB;
            header("Refresh:0");

        } else {
            unset($_SESSION['key']);
            if (!isset($_GET['error'])) header("Location: Configuration.php?error=true");
        }
    }
?>

<div class="modal fade show" id="loginModal" tabindex="-1" role="" style="display: block; padding-right: :15px; position: inherit; overflow: inherit">
    <div class="modal-dialog modal-login" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <div class="card-header card-header-primary text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>

                        <h4 class="card-title">Log in</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form" method="POST" action="" onsubmit="return handleForm(this)" id="form-login">
                        <?php if (isset($_GET['error'])) echo "<p class=\"description text-center\">Wrong username or password</p>" ?>
                        <div class="card-body">

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="material-icons">email</i></div>
                                    </div>
                                    <input type="text" class="form-control" name="username" placeholder="Username...">
                                </div>
                            </div>

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="material-icons">lock_outline</i></div>
                                    </div>
                                    <input type="password" placeholder="Password..." name="password" class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:submit()" class="btn btn-primary btn-link btn-wd btn-lg">Login</a>
                </div>
            </div>
        </div>`
    </div>
</div>

<script type="text/javascript">
    function submit() {
        $('#form-login').submit();
    }

    function handleForm(form) {
        if (form.username.value === "" || form.password.value === "" ) {
            alert("Wrong");
            return false;
        }

        form.password.value = md5(form.password.value);

        return true;
    }
</script>
