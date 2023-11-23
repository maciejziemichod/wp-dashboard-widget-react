import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App.tsx";

const widget = document.getElementById("graph-widget-dashboard-widget");

if (widget !== null) {
	ReactDOM.createRoot(widget).render(
		<React.StrictMode>
			<App />
		</React.StrictMode>,
	);
}
