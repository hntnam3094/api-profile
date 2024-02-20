import OfficeLayout from "@/Layouts/OfficeLayout";
import FormGeneration from "../Components/FormGeneration";
import { useForm } from "react-hook-form";
import { Button } from "flowbite-react";
import { router } from "@inertiajs/react";
export default function FormDetail({
    dataForm,
    structionForm,
    id
}) {
    const {
        register: registerRHF,
        watch: watchRHF,
        control: controlRHF,
        unregister: unregisterRHF,
        setValue: setValueRHF,
    } = useForm({ defaultValues: dataForm });

    function edit () {
        router.get(route('structionpages.edit', {id: id, 'is_list': 0 }))
    }

    return (
        <OfficeLayout>
            <FormGeneration
                    form={structionForm}
                    register={registerRHF}
                    watch={watchRHF}
                    control={controlRHF}
                    unregister={unregisterRHF}
                    setValue={setValueRHF}
                    isDetail={1}
                />

                <div className="flex gap-5">
                    <Button color="warning" onClick={edit}>Edit</Button>
                    <Button onClick={() => history.back()}>Back</Button>
                </div>
        </OfficeLayout>
    );
}
