import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App.tsx";
import "./index.css";

const widget = document.getElementById("root");

if (widget !== null) {
	ReactDOM.createRoot(widget).render(
		<React.StrictMode>
			<App />
		</React.StrictMode>,
	);
}
