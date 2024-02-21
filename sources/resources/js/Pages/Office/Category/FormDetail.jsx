import OfficeLayout from "@/Layouts/OfficeLayout";
import FormGeneration from "../Components/FormGeneration";
import { useForm } from "react-hook-form";
import { router } from "@inertiajs/react";
import { Button } from "flowbite-react";

export default function FormDetail({ dataForm, form, id = 0 }) {
    const {
        register: registerRHF,
        handleSubmit: handleSubmitRHF,
        watch: watchRHF,
        control: controlRHF,
        unregister: unregisterRHF,
        setValue: setValueRHF,
    } = useForm({ defaultValues: dataForm });

    function edit () {
        router.get(route('category.edit', {id: id}))
    }

    return (
        <OfficeLayout>
            <FormGeneration
                    form={form.category}
                    register={registerRHF}
                    watch={watchRHF}
                    control={controlRHF}
                    unregister={unregisterRHF}
                    setValue={setValueRHF}
                    isDetail={1}
                />

                <div className="flex gap-5">
                    <Button color="warning" onClick={edit}>
                        Edit
                    </Button>
                    <Button onClick={() => history.back()}>Back</Button>
                </div>
        </OfficeLayout>
    );
}
