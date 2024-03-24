import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Navbar from '../components/molecules/navbar/Navbar';
import Footer from '../components/molecules/footer/Footer';

const Citas = () => {
    const [citas, setCitas] = useState([]);
    const [error, setError] = useState(null);
    const [carDetails, setCarDetails] = useState({});
    const [serviceDetails, setServiceDetails] = useState({});

    useEffect(() => {
        const fetchCitas = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/citas');
                setCitas(response.data);
                setError(null);
            } catch (error) {
                console.error('Error al obtener las citas:', error);
                setError('Error al cargar las citas. Por favor, inténtalo de nuevo más tarde.');
            }
        };

        fetchCitas();
    }, []);

    useEffect(() => {
        const fetchCarDetails = async (id_car) => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/coches/coche/${id_car}`);
                setCarDetails((prevDetails) => ({ ...prevDetails, [id_car]: response.data }));
            } catch (error) {
                console.error('Error al obtener los detalles del coche:', error);
            }
        };

        const fetchServiceDetails = async (id_service) => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/servicios/servicio/${id_service}`);
                setServiceDetails((prevDetails) => ({ ...prevDetails, [id_service]: response.data }));
            } catch (error) {
                console.error('Error al obtener los detalles del servicio:', error);
            }
        };

        citas.forEach((cita) => {
            if (!carDetails[cita.id_car]) {
                fetchCarDetails(cita.id_car);
            }
            if (!serviceDetails[cita.id_service]) {
                fetchServiceDetails(cita.id_service);
            }
        });
    }, [citas, carDetails, serviceDetails]);

    return (
        <>
            <Navbar />

            <div className="max-w-screen-xl mx-auto p-4">
                <h2 className="text-2xl font-bold mb-4">Lista de Citas</h2>
                {error && <p className="text-red-500">{error}</p>}
                <ul>
                    {citas && citas.map((cita) => {
                        console.log(cita);
                        const carName = carDetails[cita.id_car]?.model || 'Desconocido';
                        const serviceName = serviceDetails[cita.id_service]?.name || 'Desconocido';
                        return (
                            <li key={cita.id} className="mb-6">
                                <h3 className="text-lg font-semibold mb-1">{cita.date}</h3>
                                <p className="text-sm text-gray-500 mb-1">Coche: {carName}</p>
                                <p className="text-sm text-gray-500">Servicio: {serviceName}</p>
                                <p className="text-sm text-gray-500">Descripción: {cita.description}</p>
                            </li>
                        );
                    })}
                </ul>
            </div>

            <Footer />
        </>
    );
};

export default Citas;