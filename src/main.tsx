import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App.tsx";

const widget = document.getElementById("admin-graph-widget");

if (widget !== null) {
	ReactDOM.createRoot(widget).render(
		<React.StrictMode>
			<App />
		</React.StrictMode>,
	);
}
