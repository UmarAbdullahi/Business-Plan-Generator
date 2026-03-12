const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

function el(id){ return document.getElementById(id); }

function linesToArray(text) {
  return (text || "").split("\n").map(s => s.trim()).filter(Boolean);
}

function csv12ToNumbers(text) {
  const arr = (text || "").split(",").map(x => Number(String(x).trim()));
  if (arr.length !== 12 || arr.some(n => Number.isNaN(n))) return new Array(12).fill(0);
  return arr;
}

function td(child){
  const cell = document.createElement("td");
  cell.style.padding = "6px";
  cell.appendChild(child);
  return cell;
}

function createTable(containerId, columns, addBtnId, rowFactory) {
  const container = el(containerId);
  const table = document.createElement("table");
  table.innerHTML = `
    <thead><tr>${columns.map(c => `<th>${c}</th>`).join("")}</tr></thead>
    <tbody></tbody>
  `;
  container.innerHTML = "";
  container.appendChild(table);

  const tbody = table.querySelector("tbody");

  function addRow(initial = {}) {
    const tr = document.createElement("tr");
    const row = rowFactory(initial);
    tr.append(...row.cells);
    tbody.appendChild(tr);
  }

  addRow({});
  addRow({});

  el(addBtnId).addEventListener("click", () => addRow({}));

  return () => {
    const rows = [];
    [...tbody.querySelectorAll("tr")].forEach(tr => {
      const obj = {};
      [...tr.querySelectorAll("input,textarea")].forEach(inp => {
        obj[inp.dataset.key] = inp.value.trim();
      });
      if (Object.values(obj).some(v => v)) rows.push(obj);
    });
    return rows;
  };
}

// Tables
const getProducts = createTable("productsTable", ["Name", "Description", "Price (₦)"], "addProduct", (initial) => {
  const mk = (k, type="input") => {
    const inp = document.createElement(type);
    inp.dataset.key = k;
    inp.value = initial[k] || "";
    inp.style.width = "100%";
    inp.style.padding = "8px";
    inp.style.border = "1px solid #eef2f7";
    inp.style.borderRadius = "10px";
    return inp;
  };
  return { cells: [td(mk("name")), td(mk("desc","textarea")), td(mk("price"))] };
});

const getCompetitors = createTable("competitorTable", ["Competitor","Strength","Weakness","Our Edge"], "addCompetitor", (initial) => {
  const mk = (k) => {
    const inp = document.createElement("input");
    inp.dataset.key = k;
    inp.value = initial[k] || "";
    inp.style.width = "100%";
    inp.style.padding = "8px";
    inp.style.border = "1px solid #eef2f7";
    inp.style.borderRadius = "10px";
    return inp;
  };
  return { cells: [td(mk("name")), td(mk("strength")), td(mk("weakness")), td(mk("edge"))] };
});

const getTeam = createTable("teamTable", ["Name","Role","Experience"], "addTeam", (initial) => {
  const mk = (k) => {
    const inp = document.createElement("input");
    inp.dataset.key = k;
    inp.value = initial[k] || "";
    inp.style.width = "100%";
    inp.style.padding = "8px";
    inp.style.border = "1px solid #eef2f7";
    inp.style.borderRadius = "10px";
    return inp;
  };
  return { cells: [td(mk("name")), td(mk("role")), td(mk("experience"))] };
});

const getMilestones = createTable("milestoneTable", ["Month","Milestone","Owner"], "addMilestone", (initial) => {
  const mk = (k) => {
    const inp = document.createElement("input");
    inp.dataset.key = k;
    inp.value = initial[k] || "";
    inp.style.width = "100%";
    inp.style.padding = "8px";
    inp.style.border = "1px solid #eef2f7";
    inp.style.borderRadius = "10px";
    return inp;
  };
  return { cells: [td(mk("month")), td(mk("item")), td(mk("owner"))] };
});

const getRisks = createTable("riskTable", ["Risk","Impact","Mitigation"], "addRisk", (initial) => {
  const mk = (k) => {
    const inp = document.createElement("input");
    inp.dataset.key = k;
    inp.value = initial[k] || "";
    inp.style.width = "100%";
    inp.style.padding = "8px";
    inp.style.border = "1px solid #eef2f7";
    inp.style.borderRadius = "10px";
    return inp;
  };
  return { cells: [td(mk("risk")), td(mk("impact")), td(mk("mitigation"))] };
});

// Charts
let charts = {};

function destroyCharts() {
  Object.values(charts).forEach(c => c?.destroy?.());
  charts = {};
}

function renderCharts() {
  destroyCharts();

  const revenue = csv12ToNumbers(el("rev12").value);
  const expenses = csv12ToNumbers(el("exp12").value);
  const cashflow = revenue.map((r,i) => r - (expenses[i] || 0));
  const breakeven = Number(el("breakeven").value || 0);

  const tam = Number(el("tam").value || 0);
  const sam = Number(el("sam").value || 0);
  const som = Number(el("som").value || 0);

  charts.revenue = new Chart(el("chartRevenue"), {
    type: "line",
    data: { labels: months, datasets: [{ label: "Revenue (₦)", data: revenue }] },
    options: { responsive: true }
  });

  charts.cashflow = new Chart(el("chartCashflow"), {
    type: "bar",
    data: { labels: months, datasets: [{ label: "Net Cashflow (₦)", data: cashflow }] },
    options: { responsive: true }
  });

  charts.expenses = new Chart(el("chartExpenses"), {
    type: "pie",
    data: { labels: months, datasets: [{ label: "Expenses (₦)", data: expenses }] },
    options: { responsive: true }
  });

  charts.breakeven = new Chart(el("chartBreakeven"), {
    type: "line",
    data: {
      labels: months,
      datasets: [
        { label: "Revenue (₦)", data: revenue },
        { label: "Breakeven (₦)", data: new Array(12).fill(breakeven) }
      ]
    },
    options: { responsive: true }
  });

  charts.tamsamsom = new Chart(el("chartTamsamsom"), {
    type: "bar",
    data: { labels: ["TAM","SAM","SOM"], datasets: [{ label: "Market Size (₦)", data: [tam, sam, som] }] },
    options: { responsive: true }
  });

  // Timeline (count milestones by month)
  const milestoneRows = getMilestones();
  const milestoneCounts = new Array(12).fill(0);
  milestoneRows.forEach(r => {
    const m = (r.month || "").toLowerCase();
    const idx = months.findIndex(x => x.toLowerCase() === m.slice(0,3));
    if (idx >= 0) milestoneCounts[idx] += 1;
  });
  charts.timeline = new Chart(el("chartTimeline"), {
    type: "bar",
    data: { labels: months, datasets: [{ label: "Milestones", data: milestoneCounts }] },
    options: { responsive: true }
  });

  // Org (count roles)
  const teamRows = getTeam();
  const roleCounts = {};
  teamRows.forEach(r => {
    const role = (r.role || "Role").trim() || "Role";
    roleCounts[role] = (roleCounts[role] || 0) + 1;
  });
  charts.org = new Chart(el("chartOrg"), {
    type: "bar",
    data: {
      labels: Object.keys(roleCounts).slice(0,8),
      datasets: [{ label: "Team Roles Count", data: Object.values(roleCounts).slice(0,8) }]
    },
    options: { responsive: true }
  });

  // Funnel (simple default numbers)
  charts.funnel = new Chart(el("chartFunnel"), {
    type: "bar",
    data: {
      labels: ["Awareness","Interest","Conversion","Retention"],
      datasets: [{ label: "Funnel (relative)", data: [100, 60, 25, 15] }]
    },
    options: { responsive: true }
  });
}

function chartToDataUri(canvasId) {
  return el(canvasId).toDataURL("image/png", 1.0);
}

// Pack JSON for server and submit normal form
function buildPayload() {
  const revenue = csv12ToNumbers(el("rev12").value);
  const expenses = csv12ToNumbers(el("exp12").value);
  const monthly_table = months.map((m, i) => {
    const r = revenue[i] || 0;
    const e = expenses[i] || 0;
    return { month: m, revenue: r, expenses: e, net: (r - e) };
  });

  return {
    meta: {
      page_size: "A4",
      style: "pitch-deck",
      layout: "continuous",
      duration: "1 year (monthly)"
    },
    branding: {
      primary: el("primaryColor").value,
      accent: el("accentColor").value
    },
    currency: "₦",
    business: {
      name: el("bizName").value.trim(),
      tagline: el("tagline").value.trim(),
      business_model: el("bizModel").value.trim(),
      pricing: el("pricing").value.trim()
    },
    sections: {
      executive_summary: el("execSummary").value.trim(),
      problem_points: linesToArray(el("problemPoints").value),
      solution_points: linesToArray(el("solutionPoints").value),
      products: el("productsText").value.trim(),
      market_summary: el("marketSummary").value.trim(),
      sales_strategy: el("salesStrategy").value.trim(),
      operations: el("operationsText").value.trim(),
      team: el("teamText").value.trim()
    },
    products_list: getProducts(),
    market: {
      target_customers: el("targetCustomers").value.trim(),
      primary_market: el("primaryMarket").value.trim(),
      go_to_market: el("gtm").value.trim(),
      channels: linesToArray(el("channels").value),
      competitors: linesToArray(el("competitors").value)
    },
    competitor_table: getCompetitors(),
    team: { members: getTeam() },
    operations: {
      resources: el("resources").value.trim(),
      partners: el("partners").value.trim()
    },
    milestones: getMilestones(),
    risks: getRisks(),
    financials: {
      assumptions: linesToArray(el("assumptions").value),
      monthly_table
    },
    charts: {
      revenue: chartToDataUri("chartRevenue"),
      cashflow: chartToDataUri("chartCashflow"),
      expenses: chartToDataUri("chartExpenses"),
      breakeven: chartToDataUri("chartBreakeven"),
      tamsamsom: chartToDataUri("chartTamsamsom"),
      timeline: chartToDataUri("chartTimeline"),
      org_chart: chartToDataUri("chartOrg"),
      marketing_funnel: chartToDataUri("chartFunnel")
    }
  };
}

// Only wire up handlers once DOM is ready and elements exist
window.addEventListener('DOMContentLoaded', () => {
  const btnExport = document.getElementById('btnExport');
  const btnRefreshCharts = document.getElementById('btnRefreshCharts');
  const form = document.getElementById('bpForm');
  const packedData = document.getElementById('packedData');

  if (!btnExport || !btnRefreshCharts || !form || !packedData) {
    console.warn('Business Plan JS loaded but required elements are missing:', {
      btnExport: !!btnExport,
      packedData: !!packedData,
      form: !!form,
    });
    return;
  }

  btnRefreshCharts.addEventListener('click', renderCharts);

  btnExport.addEventListener('click', () => {
    renderCharts();
    const payload = buildPayload();
    packedData.value = JSON.stringify(payload);
    form.submit();
  });

  // initial charts
  renderCharts();
});