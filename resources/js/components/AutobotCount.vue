<template>
    <div class="autobot-container">
        <h1 class="autobot-count">Autobots Count: {{ autobotCount }}</h1>
    </div>
</template>

<script>
export default {
    data() {
        return {
            autobotCount: 0
        };
    },
    mounted() {
        console.log("Mounted and waiting for Echo ...........");
        // Set up real-time WebSockets
        Echo.channel('autobots')
            .listen('.autobot.created', (event) => {
                console.log("New Autobot created:", event.autobot);
                this.autobotCount = event.autobot;
            })
            .error((error) => {
                console.error('Echo Connection Error:', error);
            });
    }
}
</script>

<style scoped>
.autobot-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f0f4f8;
    font-family: Arial, sans-serif;
}

.autobot-count {
    font-size: 2rem;
    color: #333;
    background-color: #e0e4e8;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
