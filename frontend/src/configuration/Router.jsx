import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Home from '../pages/Home';
import Citas from '../pages/Citas';


function Router() {
  return (
    <BrowserRouter>
    <Routes>
        <Route path="/" element={<Home/>}></Route>
        <Route path="/citas" element={<Citas/>}></Route>
         {/*<Route path="/product" element={<Product/>}></Route>
         <Route path="/cart" element={<Cart/>}></Route>
         <Route path="/createproduct" element={<CreateProduct/>}></Route>  */}
    </Routes>
</BrowserRouter>
  )
}

export default Router