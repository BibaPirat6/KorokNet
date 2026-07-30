if (document.getElementById("registration")) {
    // reg
    const email = document.getElementById("reg_email")
    const login = document.getElementById("reg_login")
    const fio = document.getElementById("reg_fio")
    const phone = document.getElementById("reg_phone")
    const pwd = document.getElementById("reg_pwd")

    const errorText = {
        email: document.getElementById("reg_error_email"),
        login: document.getElementById("reg_error_login"),
        fio: document.getElementById("reg_error_fio"),
        phone: document.getElementById("reg_error_phone"),
        pwd: document.getElementById("reg_error_pwd"),
    }

    const regData = {
        email: document.getElementById("reg_email").value,
        login: document.getElementById("reg_login").value,
        fio: document.getElementById("reg_fio").value,
        phone: document.getElementById("reg_phone").value,
        pwd: document.getElementById("reg_pwd").value,
    }

    function validateEmail() {
        const regex = /^\S+@\S+\.\S+$/
        if (!regex.test(regData.email) || regData.email.length < 5 || regData.email.length > 255) {
            errorText.email.textContent = "почта от 5 до 255 символов"
            return false
        }
        errorText.email.textContent = ""
        return true
    }

    function validateLogin() {
        const regex = /^[A-Za-z0-9]{6,255}$/
        if (!regex.test(regData.login)) {
            errorText.login.textContent = "логин 6–255, англ + цифры"
            return false
        }
        errorText.login.textContent = ""
        return true
    }

    function validateFio() {
        const regex = /^[А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+$/ui
        if (!regex.test(regData.fio) || regData.fio.length < 5 || regData.fio.length > 255) {
            errorText.fio.textContent = "ФИО: Иванов Иван Иванович"
            return false
        }
        errorText.fio.textContent = ""
        return true
    }

    function validatePhone() {
        const regex = /^\d{11,20}$/
        if (!regex.test(regData.phone)) {
            errorText.phone.textContent = "телефон 11–20 цифр"
            return false
        }
        errorText.phone.textContent = ""
        return true
    }

    function validatePwd() {
        const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,255}$/i
        if (!regex.test(regData.pwd)) {
            errorText.pwd.textContent = "пароль слабый"
            return false
        }
        errorText.pwd.textContent = ""
        return true
    }


    email.addEventListener("input", e => {
        regData.email = e.target.value
        validateEmail()
    })
    login.addEventListener("input", e => {
        regData.login = e.target.value
        validateLogin()
    })
    fio.addEventListener("input", e => {
        regData.fio = e.target.value
        validateFio()
    })
    phone.addEventListener("input", e => {
        regData.phone = e.target.value
        validatePhone()
    })
    pwd.addEventListener("input", e => {
        regData.pwd = e.target.value
        validatePwd()
    })

    const formReg = document.querySelector(".form__reg")
    formReg.addEventListener("submit", (e) => {
        e.preventDefault()
        const isValid =
            validateEmail() &&
            validateLogin() &&
            validateFio() &&
            validatePhone() &&
            validatePwd()

        if (!isValid) return

        formReg.submit()
    })
}



if (document.getElementById("authorization")) {
    const login = document.getElementById("auth_login")
    const pwd = document.getElementById("auth_pwd")
    const formAuth = document.querySelector(".form__auth")

    const errorText = {
        login: document.getElementById("auth_error_login"),
        pwd: document.getElementById("auth_error_pwd"),
    }

    function validateLogin() {
        const value = login.value.trim()
        const regex = /^[A-Za-z0-9]{6,255}$/

        if (!regex.test(value)) {
            errorText.login.textContent = "логин 6–255, англ + цифры"
            return false
        }

        errorText.login.textContent = ""
        return true
    }

    function validatePwd() {
        const value = pwd.value
        const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,255}$/i

        if (!regex.test(value)) {
            errorText.pwd.textContent = "пароль слабый"
            return false
        }

        errorText.pwd.textContent = ""
        return true
    }

    login.addEventListener("input", validateLogin)
    pwd.addEventListener("input", validatePwd)

    formAuth.addEventListener("submit", (e) => {
        e.preventDefault()


        let isValid = false
        if (login.value !== "Admin") {
            isValid = validateLogin() && validatePwd()
        } else if (login.value === "Admin" && pwd.value === "KorokNET") {
            isValid = true
        }

        if (!isValid) return

        formAuth.submit()
    })
}







if (document.getElementById("review")) {
    const review = document.getElementById("review_msg")

    const errorText = {
        review: document.getElementById("review_error_msg")
    }

    const regData = {
        review: ""
    }

    let error = false

    review.addEventListener("input", (e) => {
        regData.review = e.target.value
        const regex = /^[\p{L}\p{N}\p{P}\p{S}\s]{10,500}$/u
        if (!regex.test(regData.review)) {
            error = true
            errorText.review.textContent = "комментарий длиной 10 - 500 символов"
        } else {
            error = false
            errorText.review.textContent = ""
        }
    })

    const formReg = document.querySelector(".form__review")
    formReg.addEventListener("submit", (e) => {
        e.preventDefault();

        if (error || !regData.review) {
            alert("Ошибка заполнения полей")
        } else {
            alert("Успешно")
            formReg.submit()
        }
    });
}