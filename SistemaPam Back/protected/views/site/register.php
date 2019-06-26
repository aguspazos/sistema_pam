        <link href="/css/site/register.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/site/register.js"></script>
        <div id="mainText">
            INGRESÁ TUS DATOS
            <div id="mainTextUnderline"></div>
        </div>
        <div id="registerForm">
            <div class="registerFormFieldBox">
                <div class="registerFormFieldTitle">Nombre</div>
                <div class="registerFormFieldOuter">
                    <input id="first_name" class="registerFormField" type="text"/>
                </div>
            </div>
            <div class="registerFormFieldBox">
                <div class="registerFormFieldTitle">Apellido</div>
                <div class="registerFormFieldOuter">
                    <input id="last_name" class="registerFormField" type="text"/>
                </div>
            </div>
            <div class="registerFormFieldBox">
                <div class="registerFormFieldTitle">Teléfono</div>
                <div class="registerFormFieldOuter">
                    <input id="phone" class="registerFormField" type="text"/>
                </div>
            </div>
            <div class="registerFormFieldBox">
                <div class="registerFormFieldTitle">Email</div>
                <div class="registerFormFieldOuter">
                    <input id="email" class="registerFormField" type="text"/>
                </div>
            </div>
            <div class="registerFormFieldBox">
                <div class="registerFormFieldTitle">Direccion</div>
                <div class="registerFormFieldOuter">
                    <input id="address" class="registerFormField" type="text"/>
                </div>
            </div>
            <div class="registerFormFieldBox">
                <div class="registerFormFieldTitle">Sexo</div>
                <div class="registerFormRadioOuter">
                    <input class="registerFormRadioOption" type="radio" name="gender" id="maleGender" value="male">
                    <div class="registerFormRadioOptionTitle">Masculino</div>
                    <input class="registerFormRadioOption" type="radio" name="gender" id="femaleGender" value="female">
                    <div class="registerFormRadioOptionTitle">Femenino</div>
                </div>
            </div>
            <div class="registerFormFieldBox">
                <div class="registerFormFieldTitle">Código del STICKER</div>
                <div class="registerFormFieldOuter">
                    <input id="code" class="registerFormField" type="text"/>
                </div>
            </div>
            <div class="registerFormFieldBox">
                <div class="registerFormFieldTitle">C.I.</div>
                <div class="registerFormFieldOuter">
                    <input id="ci" class="registerFormField" type="text"/>
                </div>
            </div>
        </div>
        <div id="acceptTermsRow">
            <div id="acceptTermsSquare"></div>
            <div id="acceptTermsTick">&#10003;</div>
            <div id="acceptTermsClick"></div>
            <div id="acceptTermsText">SOY MAYOR DE 20 AÑOS Y ACEPTO LAS BASES & CONDICIONES</div>
        </div>
        <img id="registrate" src="/files/site/registrate.png"/>
        <input type="hidden" id="auxTimer"/>