import { useState } from "react"
import toast from 'react-hot-toast';
import { LoginToAccount } from "../../api/AuthApi";

export const LoginPage = () => {
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
    const [logging, setLogging] = useState(false);

    const makeLogin = () => {
        return new Promise(async (accept, reject) => {
            const xreponse = await LoginToAccount(username, password);

            if (xreponse.status) accept();
            else reject(xreponse.err);

            if(xreponse.status){
                localStorage.setItem("accountToken", xreponse.token ?? "-1");
            }
        });
    }

    const handleLogin = () => {
        if (logging) return;
        setLogging(true);
        const loginresponse = makeLogin();

        toast.promise(
            loginresponse,
            {
                loading: () => <>Acessando painel...</>,
                success: (res) => <>Login realizado com sucesso!</>,
                error: (res) => <>{res || "Erro ao fazer login"}</>
            },
            {
                className: "bg-zinc-900 text-white border border-zinc-800"
            }
        );

        loginresponse.finally(() => {
            setLogging(false);
        });
    }

    return (
        <div className="flex flex-col items-center justify-center w-full h-screen bg-[#08080a] text-white px-4">
            <div className="flex flex-col justify-center rounded-xl w-full max-w-md bg-[#121216] border border-[#22222a] p-8 shadow-2xl gap-5">
                
                <div className="flex flex-col gap-1 text-center">
                    <h1 className="text-2xl font-bold tracking-tight text-white">Painel Revendedor</h1>
                    <p className="text-sm text-zinc-400">Acesse sua conta</p>
                </div>

                <div className="flex flex-col gap-4 mt-2">
                    <div className="flex flex-col gap-1.5">
                        <label className="text-xs font-medium text-zinc-300">E-mail</label>
                        <input 
                            value={username} 
                            onChange={e => setUsername(e.currentTarget.value)} 
                            type="email" 
                            placeholder="seu@email.com" 
                            className="w-full bg-[#18181d] border border-[#2a2a33] rounded-lg p-3 text-white placeholder-zinc-500 focus:outline-none focus:border-purple-600 text-sm transition-colors" 
                        />
                    </div>

                    <div className="flex flex-col gap-1.5">
                        <label className="text-xs font-medium text-zinc-300">Senha</label>
                        <input 
                            value={password} 
                            onChange={e => setPassword(e.currentTarget.value)} 
                            type="password" 
                            placeholder="••••••••" 
                            className="w-full bg-[#18181d] border border-[#2a2a33] rounded-lg p-3 text-white placeholder-zinc-500 focus:outline-none focus:border-purple-600 text-sm transition-colors" 
                        />
                    </div>

                    <button 
                        onClick={handleLogin} 
                        className="w-full mt-2 rounded-lg bg-[#7c3aed] hover:bg-[#6d28d9] font-medium text-sm py-3 text-white transition-all shadow-lg shadow-purple-900/30 flex items-center justify-center"
                    >
                        {logging ?
                            <div className="w-5 h-5 border-2 border-white border-t-transparent animate-spin rounded-full"></div> :
                            <span>Acessar Painel</span>
                        }
                    </button>
                </div>

                <div className="flex justify-center items-center mt-2 text-sm text-zinc-400">
                    <span>Não tem conta?&nbsp;</span>
                    <a href="/register" className="text-purple-400 hover:text-purple-300 hover:underline font-medium">Registre-se</a>
                </div>
            </div>
        </div>
    );
}
