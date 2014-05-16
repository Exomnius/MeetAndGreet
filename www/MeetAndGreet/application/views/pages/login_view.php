<div class="container">
    {form_open}
    {validation_errors}
    <h2 class="form-signin-heading col-lg-10 col-lg-offset-2">Inloggen</h2>

    <div class="row">
        <div class="col-lg-2">
            <span class="glyphicon glyphicon-user btn-lg"></span> 
        </div>
        <div class="col-lg-10">
            <input type="text" name="username" class="form-control" placeholder="Gebruikersnaam" 
                   value="{username}"/>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <span class="glyphicon glyphicon-lock btn-lg"></span> 
        </div>
        <div class="col-lg-10">
            <input type="password" name="password" class="form-control" placeholder="Wachtwoord"/>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 col-lg-offset-2">
            <input type="checkbox" name="remember" value="remember-me" checked/>
            <label style="margin-left: 10px;">Onthou mij</label><a href="{forgot}" class="pull-right">Wachtwoord vergeten?</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 col-lg-offset-2">
            <input type="submit" name="signUp" value="Log in" class="btn btn-lg btn-primary btn-block"/>
        </div>
    </div>
    {form_close}
</div>