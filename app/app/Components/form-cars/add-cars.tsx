import { useNavigate } from "react-router";
import { useState } from "react";
import axios from "axios";
import { FormCars } from "./from";

export interface Cars {
  id?: number;
  brand: string | null;
  model: string | null;
  litle_name: string | null;
  first_registration_date: string | null;
  price: number | null;
}

export function AddCars() {
  const [cars, setCars] = useState<Cars>({
    brand: "",
    model: "",
    litle_name: "",
    first_registration_date: "",
    price: 0,
  });

  const handleChangeBrand = (e: React.ChangeEvent<HTMLInputElement>) => 
    setCars({ ...cars, brand: e.target.value });

  const handleChangeModel = (e: React.ChangeEvent<HTMLInputElement>) => 
    setCars({ ...cars, model: e.target.value });

  const handleChangeLitleName = (e: React.ChangeEvent<HTMLInputElement>) => 
    setCars({ ...cars, litle_name: e.target.value });

  const handleChangeFirstRegistrationDate = (e: React.ChangeEvent<HTMLInputElement>) => 
    setCars({ ...cars, first_registration_date: e.target.value });

  const handleChangePrice = (e: React.ChangeEvent<HTMLInputElement>) => 
    setCars({ ...cars, price: parseInt(e.target.value) });

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    console.log(cars);
    axios.post("http://localhost:81/cars", cars)
      .then((response) => {
        console.log(response);
      })
      .catch((error) => {
        console.log(error);
      });
  };

  return (
    <FormCars
      handleSubmit={handleSubmit}
      handleChangeBrand={handleChangeBrand}
      handleChangeModel={handleChangeModel}
      handleChangePrice={handleChangePrice}
      handleChangeFirstRegistrationDate={handleChangeFirstRegistrationDate}
      handleChangeLitleName={handleChangeLitleName}
      cars={cars}
    />
  );
}
