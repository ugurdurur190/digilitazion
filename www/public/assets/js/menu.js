var mini = true;

function toggleSidebar() {
    if (mini) {
        console.log("opening sidebar");
        document.getElementById("mySidebar").style.width = "220px";
        document.getElementById("main").style.marginLeft = "110px";
        this.mini = false;
    } else {
        console.log("closing sidebar");
        document.getElementById("mySidebar").style.width = "65px";
        document.getElementById("main").style.marginLeft = "100px";
        this.mini = true;
    }
}