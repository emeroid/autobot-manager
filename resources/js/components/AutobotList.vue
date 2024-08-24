<template>
    <div class="autobot-list-container">
        <ul class="autobot-list">
            <li v-for="autobot in autobots" :key="autobot.id" class="autobot-item">
                {{ autobot.name }}
            </li>
        </ul>
        <div class="button-container">
            <button @click="loadMore()" class="load-more-button">Load More</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            autobots: [],
            page: 1
        };
    },
    mounted() {
        this.fetchAutobots();
    },
    methods: {
        async fetchAutobots() {
            const response = await axios.get(`/api/autobots?page=${this.page}`);
            this.autobots = [...this.autobots, ...response.data.data];
        },
        loadMore() {
            this.page++;
            this.fetchAutobots();
        }
    }
}
</script>

<style scoped>
.autobot-list-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background-color: #f9f9f9;
    font-family: Arial, sans-serif;
}

.autobot-list {
    list-style: none;
    padding: 0;
    margin: 0;
    width: 100%;
    max-width: 600px;
}

.autobot-item {
    padding: 15px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-size: 1rem;
    color: #333;
}

.button-container {
    margin-top: 20px;
}

.load-more-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}

.load-more-button:hover {
    background-color: #0056b3;
}

.load-more-button:active {
    transform: scale(0.98);
}
</style>
