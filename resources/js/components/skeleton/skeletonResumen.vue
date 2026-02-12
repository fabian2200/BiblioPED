<template>
    <div class="loading-overlay">
        <div class="loading-card">
            <div class="spinner"></div>

            <h2 class="title">Generando respuesta...</h2>
            <p class="subtitle">
                Por favor espera un momento mientras procesamos la respuesta ✨
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoadingResumen",
};
</script>

<style scoped>
/* Fondo que cubre toda la pantalla */
.loading-overlay {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at top, #1e293b5e, #0b1220);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999999;
    padding: 20px;
}

/* Tarjeta centrada */
.loading-card {
    width: min(520px, 95%);
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 18px;
    padding: 35px 25px;
    text-align: center;
    backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    animation: fadeIn 0.35s ease;
}

/* Spinner */
.spinner {
    width: 62px;
    height: 62px;
    margin: 0 auto 18px auto;
    border-radius: 50%;
    border: 6px solid rgba(255, 255, 255, 0.18);
    border-top: 6px solid rgba(255, 255, 255, 0.9);
    animation: spin 1s linear infinite;
}

/* Texto */
.title {
    font-size: 22px;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.subtitle {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.75);
    margin-top: 10px;
    line-height: 1.5;
}

/* Animaciones */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0px);
    }
}
</style>