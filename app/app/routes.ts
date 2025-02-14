import { type RouteConfig, index, route } from "@react-router/dev/routes";

export default [
  index("routes/home.tsx"),
  route("cars/list", "routes/cars/list.tsx"),
  route("cars/add", "routes/cars/add.tsx"),
  route("car/:id", "routes/cars/car.tsx"),
  route("cars/update/:id", "routes/cars/update.tsx"),
] satisfies RouteConfig;
