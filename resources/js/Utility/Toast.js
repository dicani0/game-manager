import Swal from "sweetalert2";

const Toast = Swal.mixin({
    toast: true,
    position: "center",
    background: "#222",
    color: "#fff",
    width: "400px",
    showCancelButton: true,
});

export default Toast;
