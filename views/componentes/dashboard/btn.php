<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<section class="btns">
    <div>
        
        <span class="cont_button"  data-url="https://www.youtube.com">
            <div class="shadow"></div>
            <div class="cont_icon">
                <i class='bx bx-chevron-right'></i>
            </div>
            <p class="text">EBI (3er ciclo)</p>
        </span>

        <span class="cont_button"  data-url="https://www.youtube.com">
            <div class="shadow"></div>
            <div class="cont_icon">
                <i class='bx bx-chevron-right'></i>
            </div>
            <p class="text">FPB</p>
        </span>

        <span class="cont_button"  data-url="https://www.youtube.com">
            <div class="shadow"></div>
            <div class="cont_icon">
                <i class='bx bx-chevron-right'></i>
            </div>
            <p class="text">RUMBO</p>
        </span>

    </div>
    
</section>

<script>
    const isMobile = window.innerWidth <= 768;

    document.querySelectorAll(".cont_button").forEach(button => {
        const shadow = button.querySelector(".shadow");
        const text = button.querySelector(".text");
        const contenedor_icon = button.querySelector(".cont_icon");
        const url = button.getAttribute("data-url");

        const handleClick = () => {
            shadow.classList.add("larged");
            text.classList.add("text_change");
            contenedor_icon.innerHTML = "<i class='bx bx-right-arrow-alt'></i>";
            contenedor_icon.style.transform = "translateX(10px)";
            contenedor_icon.style.transition = "transform 0.3s";

            if (isMobile) {
                setTimeout(() => {
                    window.location.href = url;
                }, 900); // Redirigir después de 900ms (igual que la duración de la transición)
            } else {
                window.location.href = url;
            }
        };

        button.addEventListener("click", handleClick);

        if (!isMobile) {
            button.addEventListener("mouseover", function() {
                shadow.classList.add("larged");
                text.classList.add("text_change");
                contenedor_icon.innerHTML = "<i class='bx bx-right-arrow-alt'></i>";
                contenedor_icon.style.transform = "translateX(10px)";
                contenedor_icon.style.transition = "transform 0.3s";
            });

            button.addEventListener("mouseout", function() {
                shadow.classList.remove("larged");
                text.classList.remove("text_change");
                contenedor_icon.innerHTML = "<i class='bx bx-chevron-right'></i>";
                contenedor_icon.style.transform = "translateX(0)";
                contenedor_icon.style.transition = "transform 0.3s";
            });
        }
    });

    window.addEventListener("load", () => {
        document.querySelectorAll(".cont_button").forEach(button => {
            const shadow = button.querySelector(".shadow");
            const text = button.querySelector(".text");
            const contenedor_icon = button.querySelector(".cont_icon");
            
            shadow.classList.remove("larged");
            text.classList.remove("text_change");
            contenedor_icon.style.transform = "translateX(0)";
        });
    });
</script>

<style>
    .btns 
    {
        width: 100%;
        height: 100vh;
        position: absolute;
        top: 0;
        left: 0;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
    }

    .btns>div>span 
    {
        display:flex;
        gap: 15px;
        align-items: center;
        cursor: pointer;
        width: 200px;
        position: relative;
    }

    .btns>div>span>p 
    {
        text-decoration: none;
        font-family: 'Montserrat', sans-serif;
        color: #303030;
        font-weight: 400;
        width: 100%;
        text-align: center;
    }

    .btns>div>span>div>i 
    {
        color: #f2f2f2;
        font-size: 25px;
        z-index: 1;
        transition: transform ease .7s;
    }
    
    .text_change 
    {
        color: #f2f2f2!important;
        z-index: 2;
        font-weight: 500!important;
    }
    
    .btns>div 
    {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 25px;
    }

    .btns>div>span>div:not(.shadow)
    {
        background-color: #1A3864;
        height: 40px;
        aspect-ratio: 1/1;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1;
        position: relative;
    }

    .shadow 
    {
        background-color: #1A3864;
        position: absolute;
        border-radius: 20px 20px;
        z-index: 0;
        transition: width ease .7s;
        width: 40px;
        height: 40px;
    }

    .larged 
    {
        width: 100%!important;
    }

    .cont_button 
    {
        position: relative;
        display: inline-block;
    }

    @media only screen and (max-width: 479px) 
    {
        .imagenLogo 
        {
            bottom: unset;
            width: 85%;
            height: auto;
            top: 50px;
        }

        .btns>div>span 
        {
            display:flex;
            gap: 15px;
            align-items: center;
            cursor: pointer;
            width: 175px;
            position: relative;
        }
    }

</style>