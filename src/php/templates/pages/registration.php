<section class="registration-form">
    <div class="row align-items-center">
        <form method="POST">
            <label for="firstname" method="POST">First Name</label>
            <input type="input" id="firstname" name="firstname" />
            <br />
            
            <label for="surname">Surname</label>
            <input type="input" id="surname" name="surname" />
            <br />
            
            <label for="email">Surname</label>
            <input type="input" id="email" name="email" />
            <br />
            
            <label for="password">Surname</label>
            <input type="password" id="password" name="password" />
            <br />

            <label for="tos">Tick here to confirm you have read our Terms and Conditions.</label>
            <input type="checkbox" id="tos" name="tos" />
            <br />

            <label for="privacy">Tick here to confirm you have read our privacy policy.</label>
            <input type="checkbox" id="privacy" name="privacy" />
            <br />
            
            <input type="submit" id="submit" name="submit" value="Register"/>
        </form>

        <script>
            const tosCheckbox = document.getElementById('tos');
            const privacyCheckbox = document.getElementById('privacy');

            const submitButton = document.getElementById('submit');

            tosCheckbox.addEventListener('tos', e =>
            {
                if (privacyCheckbox.checked)
                {
                    submitButton = !this.checked;
                }
            });

            privacyCheckbox.addEventListener('privacy', e =>
            {
                if (tosCheckbox.checked)
                {
                    submitButton = !this.checked;
                }
            });
        </script>
    </div>
</section>