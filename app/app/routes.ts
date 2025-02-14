import { type RouteConfig, index, route } from "@react-router/dev/routes";

export default [
  index("routes/home.tsx"),
  route("cars/list", "routes/cars/list.tsx"),
  route("cars/add", "routes/cars/add.tsx"),
] satisfies RouteConfig;
