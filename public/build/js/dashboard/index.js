const aside = document.querySelector(".aside")

if (aside)
    aside.addEventListener("click", e => {
        const viewMoreBtn = aside.querySelector(".more-information")

        // console.log(e)
        if (e.target == viewMoreBtn || e.target.parentElement == viewMoreBtn) {
            aside.classList.toggle("stretch")
            // document.body.classList.toggle("fixed")
        }
    })


const account = document.querySelector(".account")
const notifications = document.querySelector(".notifications")

const subdropDownNotifications = document.querySelector(".notifications-dropdown")

const subdropDownAccount = document.querySelector(".account-dropdown")


if (account) {
    document.body.addEventListener("click", e => {
        if (e?.target == account || e?.target.parentElement == account) {
            const last = document.querySelector("visible")
            if (last) last.classList.remove("visible")
            subdropDownAccount?.classList?.add("visible")

        } else {
            subdropDownAccount?.classList?.remove("visible")
        }

        if (notifications) {
            if (e?.target == notifications || e?.target.parentElement == notifications) {
                const last = document.querySelector("visible")
                if (last) last.classList.remove("visible")
                subdropDownNotifications?.classList?.add("visible")

            } else {
                subdropDownNotifications?.classList?.remove("visible")
            }
        }
    })


}
