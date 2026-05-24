function deletePackage(packageId) {
  if (!confirm("Are you sure you want to delete this package?")) return;

  fetch("../../includes/agency_dashboard_queries.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      type: "deletePackage",
      package_id: packageId,
      agency_id: AGENCY_ID,
    }),
  })
    .then((res) => res.json())
    .then((response) => {
      if (response.success) {
        location.reload();
      } else {
        alert("Error: " + response.message);
      }
    })
    .catch((err) => console.error("Error deleting package:", err));
}
