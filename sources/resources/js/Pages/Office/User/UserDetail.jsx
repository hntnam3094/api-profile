import OfficeLayout from "@/Layouts/OfficeLayout";
import FormGeneration from "../Components/FormGeneration";
import { useForm } from "react-hook-form";
import { router, useForm as useFormInertial } from "@inertiajs/react";
import { useEffect } from "react";
import { Button } from "flowbite-react";

export default function UserDetail({ dataForm, form, id = 0 }) {
    const {
        register: registerRHF,
        handleSubmit: handleSubmitRHF,
        watch: watchRHF,
        control: controlRHF,
        unregister: unregisterRHF,
        setValue: setValueRHF,
    } = useForm({ defaultValues: dataForm });

    function edit () {
        router.get(route('user.edit', {id: id}))
    }

    return (
        <OfficeLayout>
            <FormGeneration
                    form={form.form}
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
