import './bootstrap';
import './scroll-animations';
import './notifications';
import { Chart, ArcElement, Tooltip, Legend, CategoryScale, LinearScale, BarElement, LineElement, PointElement, Filler, RadialLinearScale, RadarController, LineController, BarController, DoughnutController } from 'chart.js';

Chart.register(ArcElement, Tooltip, Legend, CategoryScale, LinearScale, BarElement, LineElement, PointElement, Filler, RadialLinearScale, RadarController, LineController, BarController, DoughnutController);
// Expose globally for compatibility with any inline scripts/components
// that might reference window.Chart
// eslint-disable-next-line no-underscore-dangle
window.Chart = Chart;

function initSummaryDonutChart() {
  console.log('[Chart Debug] initSummaryDonutChart called');
  const canvas = document.getElementById('summaryDonutChart');
  if (!canvas) {
    console.log('[Chart Debug] summaryDonutChart canvas not found');
    return;
  }
  console.log('[Chart Debug] Canvas found:', canvas);
  console.log('[Chart Debug] window.Chart available:', !!window.Chart);

  // Read labels and values from data attributes
  let labels = [];
  let values = [];
  try {
    labels = JSON.parse(canvas.getAttribute('data-labels') || '[]');
    console.log('[Chart Debug] Labels parsed:', labels);
  } catch (e) { console.log('[Chart Debug] Labels parse error:', e); }
  try {
    values = JSON.parse(canvas.getAttribute('data-values') || '[]');
    console.log('[Chart Debug] Values parsed:', values);
  } catch (e) { console.log('[Chart Debug] Values parse error:', e); }

  // Only create dummy data if both arrays are completely empty
  if (labels.length === 0 && values.length === 0) {
    console.log('[Chart Debug] No data provided, creating dummy chart');
    labels = ['No Data Available'];
    values = [1];
  } else if (labels.length === 0 || values.length === 0) {
    console.log('[Chart Debug] Mismatched data arrays, labels:', labels.length, 'values:', values.length);
    // Don't override if one has data - let Chart.js handle it
  }

  const palette = [
    { bg: 'rgba(59, 130, 246, 0.85)', border: 'rgba(59, 130, 246, 1)' },   // blue-500
    { bg: 'rgba(139, 92, 246, 0.85)', border: 'rgba(139, 92, 246, 1)' },  // purple-500
    { bg: 'rgba(16, 185, 129, 0.85)', border: 'rgba(16, 185, 129, 1)' },  // emerald-500
    { bg: 'rgba(251, 191, 36, 0.85)', border: 'rgba(251, 191, 36, 1)' },  // amber-400
    { bg: 'rgba(99, 102, 241, 0.85)', border: 'rgba(99, 102, 241, 1)' },  // indigo-500
    { bg: 'rgba(34, 197, 94, 0.85)', border: 'rgba(34, 197, 94, 1)' },    // green-500
  ];

  const colorsBg = values.map((_, i) => palette[i % palette.length].bg);
  const colorsBorder = values.map((_, i) => palette[i % palette.length].border);

  const ctx = canvas.getContext('2d');
  console.log('[Chart Debug] Creating donut chart with data:', { labels, values });

  try {
    // eslint-disable-next-line no-new
    const chart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels,
        datasets: [{
          data: values,
          backgroundColor: colorsBg,
          borderColor: colorsBorder,
          borderWidth: 2,
          hoverOffset: 6,
          cutout: '60%',
        }],
      },
      options: {
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { usePointStyle: true },
          },
          tooltip: {
            callbacks: {
              label: (context) => {
                const label = context.label || '';
                const value = context.parsed || 0;
                const total = (context.dataset.data || []).reduce((a, b) => a + (Number(b) || 0), 0) || 1;
                const pct = ((value / total) * 100).toFixed(1);
                return `${label}: ${value} (${pct}%)`;
              },
            },
          },
        },
      },
    });
    // mark as initialized to allow fallback scripts to skip re-init
    canvas.dataset.inited = '1';
    console.log('[Chart Debug] Donut chart created successfully:', chart);
  } catch (error) {
    console.error('[Chart Debug] Error creating Vite donut chart:', error);
  }
}

// Run immediately if DOM is ready, otherwise wait for DOMContentLoaded
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initSummaryDonutChart);
} else {
  initSummaryDonutChart();
}
