import Swal from "sweetalert2";

const Toast = Swal.mixin({
    toast: true,
    position: "center",
    background: "#222",
    color: "#fff",
    showCancelButton: true,
});

export default Toast;
