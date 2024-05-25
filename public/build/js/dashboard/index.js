const aside = document.querySelector(".aside")

if (aside)
    aside.addEventListener("click", e => {
        const viewMoreBtn = aside.querySelector(".more-information")

        // console.log(e)
        if (e.target == viewMoreBtn || e.target.parentElement == viewMoreBtn) {
            aside.classList.toggle("stretch")
            document.body.classList.toggle("fixed")
        }
    })