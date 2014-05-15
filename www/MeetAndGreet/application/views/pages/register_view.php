<div class="container">
    {form_open}
    {validation_errors}
    <h2 class="form-signin-heading col-lg-6 col-lg-offset-3">Registeren</h2>
    
    
    <div class="form-group">
        <label class="control-label col-sm-5">Gebruikersnaam:</label>
        <div class="col-sm-7">
            <input type="text" name="username" class="form-control" value="{username}" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-5">Voornaam:</label>
        <div class="col-sm-7">
            <input type="text" name="firstname" class="form-control" value="{firstname}" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-5">Achternaam:</label>
        <div class="col-sm-7">
            <input type="text" name="lastname" class="form-control" value="{lastname}" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-5">Geboortedatum:</label>
        <div class="col-sm-7">
            <div class='input-group date' id='dtpDob'>
                <input type='text' name="dob" class="form-control" readonly value="{dob}" />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                </span> 
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-sm-5">Geslacht:</label>
        <div class="col-sm-7">{gender}</div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-sm-5">Adres:</label>
        <div class="col-sm-7">
            <input type="text" name="address" class="form-control" value="{address}" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-5">Gemeente:</label>
        <div class="col-sm-7">
            <input type="text" name="city" class="form-control" value="{city}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-5">E-mailadres:</label>
        <div class="col-sm-7">
            <input type="text" name="email" class="form-control" value="{email}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-5">Wachtwoord:</label>
        <div class="col-sm-7">
            <input id="password" type="password" name="password" class="form-control" data-toggle="popover" data-trigger="focus" data-title="Restricties" data-content="Het wachtwoord kan bestaan uit kleine en grote letters, nummers, de speciale tekens: !@#$% en moet minstens 8 karakters lang zijn." onchange="showStrength()"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-5">Herhaal wachtwoord:</label>
        <div class="col-sm-7">
            <input type="password" name="passwordCheck" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-5 col-sm-7">
            <div class="progress form-group">
                <div id="progressbar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>  
        </div>
    </div>

    <div class="form-group">
        <div class="pull-right">
            <a href="{cancel}"><button type="button" class="btn btn-default">Cancel</button></a>
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </div>
    {form_close}
    <script>
        $(document).ready(function() {
            $('#dtpDob').datetimepicker({
                language: 'nl',
                pickTime: false
            });
            $("#password")
            .popover({
                placement: 'top'
            })
        });
        
        function showStrength(){
            var password = document.getElementById('password').value
            
            var strength = 0;
            
            if (password != '') {
                if (password.length > 7){
                    strength += 20;
                }
                if (password.match(/\d+/g)){
                    //contains number
                    strength += 30;
                }
                if(password.match(/[A-Z]/)){
                    //contains uppercase letters
                    strength += 30
                }
                if(password.match(/([!@#$%])/)){
                    //contains special characters !@#$%
                    strength += 20;
                }
            }
        
            var progressbar = document.getElementById('progressbar');
        
            if(strength <= 30){
                progressbar.setAttribute('class', 'progress-bar progress-danger')
            
            }else if(strength <= 60){
                progressbar.setAttribute('class', 'progress-bar progress-bar-warning')
            }else{
                progressbar.setAttribute('class', 'progress-bar progress-bar-success')
            }
            
            progressbar.setAttribute('style', "width: " + strength + "%");
            progressbar.setAttribute('aria-valuenow', strength);
        }
    </script>