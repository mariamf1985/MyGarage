import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Home from '../pages/Home';
import Citas from '../pages/Citas';
import NuevaCita from '../pages/NuevaCita';


function Router() {
  return (
    <BrowserRouter>
    <Routes>
        <Route path="/" element={<Home/>}></Route>
        <Route path="/citas" element={<Citas/>}></Route>
        <Route path="/nuevaCita" element={<NuevaCita/>}></Route>
         {/*<Route path="/cart" element={<Cart/>}></Route>
         <Route path="/createproduct" element={<CreateProduct/>}></Route>  */}
    </Routes>
</BrowserRouter>
  )
}

export default Router