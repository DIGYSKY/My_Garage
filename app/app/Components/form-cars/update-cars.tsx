import { useNavigate, useParams } from "react-router";
import { useState, useEffect } from "react";
import axios from "axios";
import { FormCars } from "./from";
import type { Cars } from "./add-cars";
import { Loader } from "../divers/loader";

export function UpdateCars() {
  const navigate = useNavigate();
  const { id } = useParams();
  const [cars, setCars] = useState<Cars>({
    id: 0,
    brand: "",
    model: "",
    litle_name: "",
    first_registration_date: "",
    price: 0,
  });
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<Error | null>(null);

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
    setIsLoading(true);
    setError(null);

    const updatedCar = {
      litle_name: cars.litle_name,
      brand: cars.brand,
      model: cars.model,
      first_registration_date: cars.first_registration_date,
      price: cars.price
    };


    axios.put(`http://localhost:81/cars/:${cars.id}`, updatedCar)
      .then((_) => {
        navigate("/cars/list");
        setIsLoading(false);
      })
      .catch((error) => {
        console.log(error);
        setError(error as Error);
        setIsLoading(false);
      });
  };

  useEffect(() => {
    axios.get(`http://localhost:81/cars/:${id}`)
      .then((response) => {
        if (response.data && response.data.data) {
          setCars(response.data.data);
        } else {
          throw new Error("Format de données invalide");
        }
      })
      .catch((error) => {
        console.log(error);
        setError(error as Error);
        setIsLoading(false);
      });
  }, [id]);

  if (isLoading) {
    return <Loader />;
  }

  if (error) {
    return <div>Erreur: {error.message}</div>;
  }

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
