import Chart from 'chart.js/auto';

const parseConfig = (payload) => {
    try {
        return payload ? JSON.parse(payload) : null;
    } catch (error) {
        console.error('Kevin: configuration de graphique invalide', error);
        return null;
    }
};

const buildChart = (canvas, type, data) => {
    if (!canvas || !data || !data.length) {
        return null;
    }

    const labels = data.map((item) => item.label);
    const values = data.map((item) => item.value);

    return new Chart(canvas, {
        type,
        data: {
            labels,
            datasets: [
                {
                    label: 'Inventaire',
                    data: values,
                    backgroundColor: ['#4B9CD3', '#36A2EB', '#00C49A', '#FFCF56', '#EF6C63', '#8F84D7'],
                    borderWidth: 0,
                    tension: 0.4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: type !== 'bar',
                },
            },
            scales: type === 'bar' ? {
                x: {
                    ticks: { color: '#6c757d' },
                },
                y: {
                    ticks: { color: '#6c757d' },
                    beginAtZero: true,
                },
            } : {},
        },
    });
};

export default function initCharts(root) {
    const rawConfig = root.dataset.chartConfig;
    const config = parseConfig(rawConfig);
    if (!config) {
        return;
    }

    const charts = [];
    const monthlyCanvas = root.querySelector('[data-chart="monthly"]');
    charts.push(buildChart(monthlyCanvas, 'line', config.monthlyEvolution));

    const statusCanvas = root.querySelector('[data-chart="status"]');
    charts.push(buildChart(statusCanvas, 'doughnut', config.statusBreakdown));

    const categoryCanvas = root.querySelector('[data-chart="category"]');
    charts.push(buildChart(categoryCanvas, 'bar', config.categoryTop));

    root.addEventListener('turbo:before-cache', () => {
        charts.forEach((chart) => chart && chart.destroy());
    });
}
